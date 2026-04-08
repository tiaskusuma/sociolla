<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'brand', 'description', 'price', 'original_price', 
        'stock', 'image_url', 'rating', 'category_id'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    public function getAverageRatingAttribute() {
        $avg = \Illuminate\Support\Facades\DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('order_items.product_id', $this->id)
            ->where('orders.is_rated', true)
            ->avg('orders.rating_stars');
        
        return $avg ? round($avg, 1) : 0;
    }

    public function getRatingCountAttribute() {
        return \Illuminate\Support\Facades\DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('order_items.product_id', $this->id)
            ->where('orders.is_rated', true)
            ->count();
    }
}
