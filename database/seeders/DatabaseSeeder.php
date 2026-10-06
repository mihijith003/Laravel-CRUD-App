<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => Hash::make('password')]
        );
        $admin->assignRole('admin');

        Product::create([
            'name' => 'Product 1',
            'description' => 'Description for Product 1',
            'price' => 10.99,
        ]);

        Product::create([
            'name' => 'Product 2',
            'description' => 'Description for Product 2',
            'price' => 19.99,
        ]);

        Product::create([
            'name' => 'Product 3',
            'description' => 'Description for Product 3',
            'price' => 5.49,
        ]);

        Product::create([
            'name' => 'Lenovo ThinkPad X1 Carbon',
            'description' => 'A high-end business laptop with a sleek design and powerful performance.',
            'price' => 1499.99,
        ]);

        Product::create([
            'name' => 'Apple MacBook Pro 16-inch',
            'description' => 'A premium laptop with a stunning Retina display and exceptional performance for creative professionals.',
            'price' => 2399.99,
        ]);

        Product::create([
            'name' => 'Dell XPS 13',
            'description' => 'A compact and stylish ultrabook with a nearly borderless display and long battery life.',
            'price' => 1299.99,
        ]);
    }
}
