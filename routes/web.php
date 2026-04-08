<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/admin', function () {
    return redirect('/admin/dashboard');
});

Route::get('/petugas', function () {
    return redirect('/petugas/dashboard');
});

Route::middleware([\App\Http\Middleware\UserMiddleware::class])->group(function () {
    Route::get('/home', function (\Illuminate\Http\Request $request) {
        $categories = \App\Models\Category::all();
        
        $query = \App\Models\Product::query();
        
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('filter')) {
            if ($request->filter === 'new') {
                $query->orderBy('created_at', 'desc');
            } elseif ($request->filter === 'best') {
                $query->orderBy('stock', 'asc');
            } elseif ($request->filter === 'deals') {
                $query->where('price', '<=', 100000);
            } else {
                $query->inRandomOrder(); // fallback for popular, trending
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $allProducts = $query->get();
        return view('home', compact('categories', 'allProducts'));
    })->name('home');

    Route::get('/product/{id}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
});

Route::middleware(['auth', \App\Http\Middleware\UserMiddleware::class])->group(function () {
    Route::get('/user-avatar', function() {
        $user = auth()->user();
        if($user && $user->avatar) {
            $path = storage_path('app/public/' . $user->avatar);
            if(file_exists($path)) return response()->file($path);
        }
        abort(404);
    })->name('user.avatar');

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product_id}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.remove');
    
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
    Route::post('/orders/{order_id}/receive', [\App\Http\Controllers\OrderController::class, 'receive'])->name('orders.receive');
    Route::post('/orders/{order_id}/cancel', [\App\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');
    
    Route::get('/payment-confirmation/{order_id}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment-confirmation/{order_id}', [\App\Http\Controllers\PaymentController::class, 'upload'])->name('payment.upload');
    Route::get('/payment/receipt/{order_id}', function($order_id) {
        $order = \App\Models\Order::with('items.product')->findOrFail($order_id);
        if($order->user_id != auth()->id()) abort(403);
        return view('payment.receipt', compact('order'));
    })->name('payment.receipt');

    Route::get('/orders/{order_id}/rate', function($order_id) {
        $order = \App\Models\Order::with('items.product')->findOrFail($order_id);
        if($order->user_id != auth()->id()) abort(403);
        return view('order.rating', compact('order'));
    })->name('orders.rate');
    
    Route::post('/orders/{order_id}/rate', [\App\Http\Controllers\OrderController::class, 'submitRating'])->name('orders.rate.submit');
});

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/products', [\App\Http\Controllers\AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [\App\Http\Controllers\AdminController::class, 'productCreate'])->name('admin.products.create');
    Route::post('/products', [\App\Http\Controllers\AdminController::class, 'productStore'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [\App\Http\Controllers\AdminController::class, 'productEdit'])->name('admin.products.edit');
    Route::post('/products/{id}/edit', [\App\Http\Controllers\AdminController::class, 'productUpdate'])->name('admin.products.update');
    Route::post('/products/{id}/delete', [\App\Http\Controllers\AdminController::class, 'productDestroy'])->name('admin.products.delete');
    Route::get('/profile', [\App\Http\Controllers\AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/profile', [\App\Http\Controllers\AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/profile/password', [\App\Http\Controllers\AdminController::class, 'updatePassword'])->name('admin.profile.password');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users.index');
    Route::post('/users/{id}/edit', [\App\Http\Controllers\AdminController::class, 'userUpdate'])->name('admin.users.update');
    Route::post('/users/{id}/delete', [\App\Http\Controllers\AdminController::class, 'userDestroy'])->name('admin.users.delete');
    Route::get('/transactions', [\App\Http\Controllers\AdminController::class, 'transactions'])->name('admin.transactions.index');
    Route::get('/transactions/{id}', [\App\Http\Controllers\AdminController::class, 'transactionDetail'])->name('admin.transactions.show');
    Route::get('/transactions/{id}/print', [\App\Http\Controllers\AdminController::class, 'transactionPrint'])->name('admin.transactions.print');
    Route::post('/order/{id}/status', [\App\Http\Controllers\AdminController::class, 'updateOrderStatus'])->name('admin.order.status');
    Route::get('/reports', [\App\Http\Controllers\AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/backup', [\App\Http\Controllers\AdminController::class, 'backup'])->name('admin.backup');
    Route::post('/backup/create', [\App\Http\Controllers\AdminController::class, 'createBackup'])->name('admin.backup.create');
    Route::get('/backup/download/{filename}', [\App\Http\Controllers\AdminController::class, 'downloadBackup'])->name('admin.backup.download');
    Route::post('/backup/delete/{filename}', [\App\Http\Controllers\AdminController::class, 'deleteBackup'])->name('admin.backup.delete');
    Route::get('/restore', [\App\Http\Controllers\AdminController::class, 'restore'])->name('admin.restore');
});

Route::middleware(['auth', \App\Http\Middleware\PetugasMiddleware::class])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [\App\Http\Controllers\AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [\App\Http\Controllers\AdminController::class, 'productCreate'])->name('products.create');
    Route::post('/products', [\App\Http\Controllers\AdminController::class, 'productStore'])->name('products.store');
    Route::get('/products/{id}/edit', [\App\Http\Controllers\AdminController::class, 'productEdit'])->name('products.edit');
    Route::post('/products/{id}/edit', [\App\Http\Controllers\AdminController::class, 'productUpdate'])->name('products.update');
    Route::post('/products/{id}/delete', [\App\Http\Controllers\AdminController::class, 'productDestroy'])->name('products.delete');
    Route::get('/profile', [\App\Http\Controllers\AdminController::class, 'profile'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\AdminController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [\App\Http\Controllers\AdminController::class, 'updatePassword'])->name('profile.password');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users.index');
    Route::post('/users/{id}/edit', [\App\Http\Controllers\AdminController::class, 'userUpdate'])->name('users.update');
    Route::post('/users/{id}/delete', [\App\Http\Controllers\AdminController::class, 'userDestroy'])->name('users.delete');
    Route::get('/transactions', [\App\Http\Controllers\AdminController::class, 'transactions'])->name('transactions.index');
    Route::get('/transactions/{id}', [\App\Http\Controllers\AdminController::class, 'transactionDetail'])->name('transactions.show');
    Route::get('/transactions/{id}/print', [\App\Http\Controllers\AdminController::class, 'transactionPrint'])->name('transactions.print');
    Route::post('/order/{id}/status', [\App\Http\Controllers\AdminController::class, 'updateOrderStatus'])->name('order.status');
    Route::get('/reports', [\App\Http\Controllers\AdminController::class, 'reports'])->name('reports');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.forgot');
    Route::post('/forgot-password', [AuthController::class, 'processForgotPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
