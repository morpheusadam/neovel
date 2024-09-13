<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_tags')->insert([
            [
                'post_id' => 1, // Assuming post with ID 1 exists
                'tag_id' => 1, // Assuming tag with ID 1 exists
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 1, // Assuming post with ID 1 exists
                'tag_id' => 2, // Assuming tag with ID 2 exists
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 2, // Assuming post with ID 2 exists
                'tag_id' => 1, // Assuming tag with ID 1 exists
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
