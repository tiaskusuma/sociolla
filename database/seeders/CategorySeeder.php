<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Category::create(['name' => 'Daily Deals']);
        \App\Models\Category::create(['name' => 'Popular Products']);
        \App\Models\Category::create(['name' => 'Best Seller']);
        \App\Models\Category::create(['name' => 'Trending']);
    }
}
