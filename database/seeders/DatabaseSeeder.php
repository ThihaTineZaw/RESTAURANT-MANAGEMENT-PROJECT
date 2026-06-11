<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Menu;
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

          $faker = Faker::create();

        User::insert([
            'name' => 'thiha',
            'email' => 'thihatinezaw@gmail.com',
            'password' => Hash::make('password'),
        ]);

        Category::insert([
            ['name' => 'Appetizers', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Main Courses', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Desserts', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Beverages', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Menu::insert([
            ['name' => 'Appetizer 1', 'price' => 10.00, 'image' => 'simple.jpg', 'description' => $faker->paragraph(), 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Main Course 1', 'price' => 20.00, 'image' => 'simple.jpg', 'description' => $faker->paragraph(), 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dessert 1', 'price' => 5.00, 'image' => 'simple.jpg', 'description' => $faker->paragraph(), 'category_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Beverage 1', 'price' => 2.00, 'image' => 'simple.jpg', 'description' => $faker->paragraph(), 'category_id' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);

       
    }
}
