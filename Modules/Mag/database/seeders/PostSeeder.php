<?php

namespace Modules\Mag\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Mag\Models\Post;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            Post::create([
                'title' => $faker->sentence,
                'slug' => $faker->slug,
                'content' => $faker->paragraph,
                'user_id' => $faker->numberBetween(1, 10), // فرض بر این است که 10 کاربر وجود دارد
                'category_id' => $faker->numberBetween(1, 5), // فرض بر این است که 5 دسته‌بندی وجود دارد
                'is_published' => $faker->boolean,
                'published_at' => $faker->optional()->dateTime,
                'image_id' => $faker->optional()->numberBetween(1, 10), // فرض بر این است که 10 تصویر وجود دارد
            ]);
        }
    }
}
