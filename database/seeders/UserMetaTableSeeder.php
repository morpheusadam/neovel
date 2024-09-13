<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserMetaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_meta')->insert([
            [
                'user_id' => 1,
                'meta_key' => 'bio',
                'meta_value' => 'This is the bio of User One.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'meta_key' => 'website',
                'meta_value' => 'https://userone.example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'meta_key' => 'bio',
                'meta_value' => 'This is the bio of User Two.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'meta_key' => 'website',
                'meta_value' => 'https://usertwo.example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more user meta data as needed
        ]);
    }
}
