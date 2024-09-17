<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            [
                'user_id' => 1, // Assuming user with ID 1 exists
                'category_id' => 1, // Assuming category with ID 1 exists
                'title' => 'First Post',
                'slug' => Str::slug('First Post'),
                'content' => 'This is the content of the first post.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1, // Assuming user with ID 1 exists
                'category_id' => 2, // Assuming category with ID 2 exists
                'title' => 'Second Post',
                'slug' => Str::slug('Second Post'),
                'content' => 'This is the content of the second post.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Assuming user with ID 2 exists
                'category_id' => 1, // Assuming category with ID 1 exists
                'title' => 'Third Post',
                'slug' => Str::slug('Third Post'),
                'content' => 'This is the content of the third post.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
