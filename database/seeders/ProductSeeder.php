<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockHistory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $products = [
            ['name' => 'Kaos Polos Premium', 'category' => 'Fashion', 'price' => 75000, 'stock' => 50],
            ['name' => 'Earphone Bluetooth', 'category' => 'Elektronik', 'price' => 150000, 'stock' => 30],
            ['name' => 'Kopi Robusta 250gr', 'category' => 'Makanan & Minuman', 'price' => 45000, 'stock' => 100],
            ['name' => 'Sapu Lantai Multifungsi', 'category' => 'Perlengkapan Rumah', 'price' => 35000, 'stock' => 20],
            ['name' => 'Vitamin C 1000mg', 'category' => 'Kesehatan', 'price' => 60000, 'stock' => 40],
            ['name' => 'Power Bank 10000mAh', 'category' => 'Elektronik', 'price' => 175000, 'stock' => 25],
        ];

        foreach ($products as $item) {
            $category = Category::where('name', $item['category'])->first();

            $product = Product::create([
                'category_id' => $category?->id,
                'name' => $item['name'],
                'slug' => Str::slug($item['name']).'-'.Str::random(5),
                'description' => 'Produk berkualitas: '.$item['name'],
                'price' => $item['price'],
                'stock' => $item['stock'],
                'sku' => 'SKU-'.strtoupper(Str::random(6)),
                'is_active' => true,
            ]);

            StockHistory::create([
                'product_id' => $product->id,
                'user_id' => $admin?->id,
                'type' => 'restock',
                'quantity' => $item['stock'],
                'stock_before' => 0,
                'stock_after' => $item['stock'],
                'note' => 'Stok awal (seeder)',
            ]);
        }
    }
}
