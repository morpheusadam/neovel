<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([
            [
                'user_id' => 1, // Assuming user with ID 1 exists
                'title' => 'About Us',
                'content' => 'This is the About Us page content.',
                'slug' => Str::slug('About Us'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1, // Assuming user with ID 1 exists
                'title' => 'Contact Us',
                'content' => 'This is the Contact Us page content.',
                'slug' => Str::slug('Contact Us'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Assuming user with ID 2 exists
                'title' => 'Privacy Policy',
                'content' => 'This is the Privacy Policy page content.',
                'slug' => Str::slug('Privacy Policy'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
