<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Solar Smart UV Light Sunscreen SPF50+ PA++++', 'brand' => 'CARASUN', 'price' => 43000, 'original_price' => 65000, 'rating' => 4.7, 'category_id' => 1, 'image_url' => 'https://via.placeholder.com/150'],
            ['name' => 'Oil Free Ultra Moisturizing Lotion (With Birch Sap)', 'brand' => 'COSRX', 'price' => 224935, 'original_price' => 299000, 'rating' => 4.7, 'category_id' => 1, 'image_url' => 'https://via.placeholder.com/150'],
            ['name' => 'Cherry Blossom Betaine Micellar Water', 'brand' => 'GLAD2GLOW', 'price' => 28000, 'original_price' => 50000, 'rating' => 4.7, 'category_id' => 1, 'image_url' => 'https://via.placeholder.com/150'],
            ['name' => 'Acne Patch Plus with Salicylic Acid Night 12', 'brand' => 'DERMAANGEL', 'price' => 43000, 'original_price' => 53000, 'rating' => 4.7, 'category_id' => 1, 'image_url' => 'https://via.placeholder.com/150'],
        ];

        foreach ($products as $p) {
            \App\Models\Product::create($p);
        }
    }
}
