<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $faker = Faker::create();

        // Seed users
        foreach (range(1, 50) as $index) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => bcrypt('password'),
                'role' => $index <= 5 ? 'editor' : 'user'
            ]);
        }

        // Seed categories
        foreach (range(1, 10) as $index) {
            Category::create([
                'title' => $faker->word
            ]);
        }

        // Seed posts
        foreach (range(1, 150) as $index) {
            Post::create([
                'user_id' => $faker->numberBetween(1, 50),
                'category_id' => $faker->numberBetween(1, 10),
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'content' => $faker->paragraph(10),
                'thumbnail' => $faker->imageUrl(),
                'views' => $faker->numberBetween(0, 1000),
                'likes' => $faker->numberBetween(0, 500)
            ]);
        }
    }
}
