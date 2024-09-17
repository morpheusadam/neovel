<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            [
                'post_id' => 1, // Assuming post with ID 1 exists
                'user_id' => 1, // Assuming user with ID 1 exists
                'content' => 'This is the first comment on the first post.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 1, // Assuming post with ID 1 exists
                'user_id' => 2, // Assuming user with ID 2 exists
                'content' => 'This is the second comment on the first post.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 2, // Assuming post with ID 2 exists
                'user_id' => 1, // Assuming user with ID 1 exists
                'content' => 'This is the first comment on the second post.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
