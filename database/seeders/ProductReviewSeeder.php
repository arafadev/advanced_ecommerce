<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();

        Product::all()->each(function ($product) use ($faker) {
            for ($i = 1; $i < rand(1, 3); $i++) {
                $product->reviews()->create([
                    'user_id' => User::inRandomOrder()->first()->id,
                    'name' => $faker->userName,
                    'email' => $faker->safeEmail,
                    'title' => $faker->sentence,
                    'message' => $faker->paragraph,
                    'status' => rand(0, 1),
                    'rating' => rand(1, 5),
                ]);
            }
        });
    }
}
