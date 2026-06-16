<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;



class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {    

        // $faker = Faker::create();

       User::updateOrCreate(
    [
        'email' => 'thihatinezaw@gmail.com',
    ],
    [
        'name' => 'thiha',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]
);
        // Category::insert([
        //     ['name' => 'DRINK', 'created_at' => now(), 'updated_at' => now()],
        //     ['name' => 'CAKE', 'created_at' => now(), 'updated_at' => now()],
        // ]);

        // Menu::insert([
        //     ['name' => 'Coke', 'price' => 1500, 'image' => 'cola.jpg', 'description' => $faker->paragraph(), 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        //     ['name' => 'Coffee', 'price' => 2000, 'image' => 'coffee.jpg', 'description' => $faker->paragraph(), 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        //     ['name' => 'Cheese Cake', 'price' => 8000, 'image' => 'cheese.jpg', 'description' => $faker->paragraph(), 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        //     ['name' => 'Chocolate Cake', 'price' => 7500, 'image' => 'choco.jpg', 'description' => $faker->paragraph(), 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        // ]);

        // //Table
        // Table::insert([
        //     ['table_number' => 'A-1', 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
        //     ['table_number' => 'A-2', 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
        //     ['table_number' => 'A-3', 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
        // ]);

        

       
    }
}
