<?php

namespace Modules\Mag\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostMetaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_meta')->insert([
            [
                'post_id' => 1, // Assuming post with ID 1 exists
                'meta_key' => 'author',
                'meta_value' => 'John Doe',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 1, // Assuming post with ID 1 exists
                'meta_key' => 'seo_title',
                'meta_value' => 'First Post SEO Title',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 2, // Assuming post with ID 2 exists
                'meta_key' => 'author',
                'meta_value' => 'Jane Smith',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 2, // Assuming post with ID 2 exists
                'meta_key' => 'seo_title',
                'meta_value' => 'Second Post SEO Title',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
