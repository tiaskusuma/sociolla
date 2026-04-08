<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard() {
        $totalProduct = Product::count();
        
        $makeupKeywords = ['cushion', 'foundation', 'lipstick', 'make over', 'powder', 'blush', 'mascara', 'makeup', 'bedak', 'liptint', 'lipcream', 'eyeshadow'];
        $makeupQuery = Product::where(function($query) use ($makeupKeywords) {
            foreach($makeupKeywords as $word) {
                $query->orWhere('name', 'LIKE', '%' . $word . '%')
                      ->orWhere('brand', 'LIKE', '%' . $word . '%');
            }
        });
        $makeupCount = $makeupQuery->count();
        $makeupBestSellers = $makeupQuery->take(3)->get();

        $skincareKeywords = ['sunscreen', 'lotion', 'water', 'acne', 'serum', 'toner', 'moisturizer', 'cleanser', 'cream', 'skincare', 'cosrx', 'glad2glow', 'dermaangel', 'carasun', 'pembersih', 'facial', 'essence'];
        $skincareQuery = Product::where(function($query) use ($skincareKeywords) {
            foreach($skincareKeywords as $word) {
                $query->orWhere('name', 'LIKE', '%' . $word . '%')
                      ->orWhere('brand', 'LIKE', '%' . $word . '%');
            }
        });
        $skincareCount = $skincareQuery->count();
        $skincareBestSellers = $skincareQuery->take(3)->get();
        
        $todaySales = Order::whereDate('created_at', \Carbon\Carbon::today())->sum('total_amount');

        $lowStockProducts = Product::where('stock', '<=', 5)->orderBy('stock', 'asc')->take(2)->get();
        $recentOrders = Order::with('items.product')->orderBy('created_at', 'desc')->take(3)->get();

        return view('admin.dashboard', compact('totalProduct', 'makeupCount', 'skincareCount', 'todaySales', 'makeupBestSellers', 'skincareBestSellers', 'lowStockProducts', 'recentOrders'));
    }

    public function products() {
        return view('admin.products');
    }

    public function profile() {
        return view('admin.profile');
    }

    public function updateOrderStatus(Request $request, $id) {
        $request->validate([
            'status' => 'nullable|in:Not Paid,Packed,Delivered,Completed',
            'tracking_status' => 'nullable|string'
        ]);

        $order = Order::findOrFail($id);
        
        if ($order->status === 'Canceled') {
            return back()->with('error', 'Pesanan yang telah dibatalkan tidak dapat diubah statusnya.');
        }
        
        if ($request->has('status')) {
            $order->update(['status' => $request->status]);
        }
        
        if ($request->has('tracking_status')) {
            $order->update(['tracking_status' => $request->tracking_status]);
        }

        return back()->with('success', 'Order status updated successfully.');
    }

    public function users() {
        $usersList = User::all();
        return view('admin.users', compact('usersList'));
    }

    public function transactions() {
        $orders = Order::with('user', 'items.product')->orderBy('created_at', 'desc')->get();
        return view('admin.transactions', compact('orders'));
    }

    public function transactionDetail($id) {
        $order = Order::with('user', 'items.product')->findOrFail($id);
        return view('admin.transaction-detail', compact('order'));
    }

    public function transactionPrint($id) {
        $order = Order::with('user', 'items.product')->findOrFail($id);
        return view('admin.transaction-print', compact('order'));
    }

    public function productCreate() {
        $categories = \App\Models\Category::all();
        return view('admin.product-create', compact('categories'));
    }

    public function productStore(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $data['image_url'] = '/sociolla/public/images/products/' . $filename;
        }

        Product::create($data);
        return redirect()->route('admin.products')->with('success', 'Product created!');
    }

    public function productEdit($id) {
        $product = Product::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('admin.product-edit', compact('product', 'categories'));
    }

    public function productUpdate(Request $request, $id) {
        $product = Product::findOrFail($id);
        $data = $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $data['image_url'] = '/sociolla/public/images/products/' . $filename;
        }

        $product->update($data);
        return redirect()->route('admin.products')->with('success', 'Product updated!');
    }

    public function productDestroy($id) {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted!');
    }

    public function reports() {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        $totalSales = Order::whereIn('status', ['Packed', 'Completed'])->sum('total_amount');
        return view('admin.reports', compact('orders', 'totalSales'));
    }
    public function backup() {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access: Admins only');
        }
        
        $backupPath = storage_path('app/backups');
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }
        
        $files = \array_diff(\scandir($backupPath), ['.', '..']);
        $backups = [];
        foreach ($files as $file) {
            if (str_ends_with($file, '.sql')) {
                $filePath = $backupPath . '/' . $file;
                $sizeMb = round(filesize($filePath) / 1048576, 2);
                $date = date("d-m-Y H:i", filemtime($filePath));
                
                $backups[] = (object)[
                    'name' => $file,
                    'size' => $sizeMb . ' MB',
                    'date' => $date,
                    'timestamp' => filemtime($filePath)
                ];
            }
        }
        
        // Sort newest first
        usort($backups, function($a, $b) { return $b->timestamp <=> $a->timestamp; });
        
        return view('admin.backup', compact('backups'));
    }

    public function createBackup() {
        if (auth()->user()->role !== 'admin') abort(403);
        
        $filename = 'sociolla_backup_' . date('Y_m_d_His') . '.sql';
        $backupPath = storage_path('app/backups');
        if (!file_exists($backupPath)) mkdir($backupPath, 0755, true);
        
        $filePath = $backupPath . '/' . $filename;
        
        $db = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        
        // Using XAMPP's mysqldump typical path if available, or just mysqldump fallback
        $mysqldumpPath = file_exists('C:\xampp\mysql\bin\mysqldump.exe') ? 'C:\xampp\mysql\bin\mysqldump.exe' : 'mysqldump';
        $passwordCmd = $pass ? "-p\"$pass\"" : "";
        
        $command = "\"$mysqldumpPath\" -u $user $passwordCmd $db > \"$filePath\"";
        exec($command, $output, $returnVar);
        
        if ($returnVar !== 0) {
            // Fallback if mysqldump fails (empty file might have been created)
            if (file_exists($filePath) && filesize($filePath) == 0) unlink($filePath);
            return back()->with('error', 'Failed to generate backup. Make sure mysqldump is accessible.');
        }
        
        return back()->with('success', 'Database backup successfully created!');
    }

    public function downloadBackup($filename) {
        if (auth()->user()->role !== 'admin') abort(403);
        $filePath = storage_path('app/backups/' . $filename);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        return back()->with('error', 'File not found!');
    }

    public function deleteBackup($filename) {
        if (auth()->user()->role !== 'admin') abort(403);
        $filePath = storage_path('app/backups/' . $filename);
        if (file_exists($filePath)) {
            unlink($filePath);
            return back()->with('success', 'Backup deleted!');
        }
        return back()->with('error', 'File not found!');
    }

    public function restore() {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access: Admins only');
        }
        return view('admin.restore');
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.auth()->id(),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        
        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->hasFile('avatar')) {
            if (!file_exists(public_path('images/users'))) {
                mkdir(public_path('images/users'), 0755, true);
            }
            $imageName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('images/users'), $imageName);
            $user->avatar = '/sociolla/public/images/users/' . $imageName;
        }
        
        $user->save();
        
        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $user = auth()->user();
        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match.');
        }
        
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();
        
        return back()->with('success', 'Password changed successfully!');
    }

    public function userUpdate(Request $request, $id) {
        $user = \App\Models\User::findOrFail($id);
        $request->validate([
            'role' => 'required|in:admin,petugas,user',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$id
        ]);
        $user->role = $request->role;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->save();
        return back()->with('success', 'User updated successfully!');
    }

    public function userDestroy($id) {
        $user = \App\Models\User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot delete your own account!');
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }
}
