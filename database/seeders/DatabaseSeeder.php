<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'balance' => 100,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $support = User::firstOrCreate(
            ['email' => 'support@example.com'],
            [
                'name' => 'Support Agent',
                'password' => Hash::make('password'),
                'role' => 'support',
                'balance' => 0,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $category = Category::firstOrCreate(['slug' => 'gift-cards'], ['name' => 'Gift Cards']);

        $products = collect([
            ['title' => 'Steam Wallet 50₺', 'sku' => 'STEAM50', 'price' => 50, 'type' => 'epin', 'supplier' => 'turkpin'],
            ['title' => 'Netflix Premium Account', 'sku' => 'NFLXACC', 'price' => 120, 'type' => 'account', 'supplier' => 'pinabi'],
            ['title' => 'Microsoft Office License', 'sku' => 'MSOFF365', 'price' => 299, 'type' => 'license', 'supplier' => 'manual'],
        ])->map(function ($data) use ($category) {
            return Product::updateOrCreate(
                ['sku' => $data['sku']],
                array_merge($data, [
                    'category_id' => $category->id,
                    'slug' => Str::slug($data['title']),
                    'stock_count' => 100,
                    'auto_deliver' => true,
                ])
            );
        });

        BlogPost::factory()->count(3)->create(['is_published' => true, 'published_at' => now()]);

        $products->each(function (Product $product) use ($admin) {
            Review::factory()->count(5)->create([
                'product_id' => $product->id,
                'user_id' => $admin->id,
                'is_fake' => true,
            ]);
        });
    }
}
