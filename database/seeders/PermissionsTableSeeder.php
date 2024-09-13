<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            [
                'permission_name' => 'view_users',
                'description' => 'Permission to view users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'edit_users',
                'description' => 'Permission to edit users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'delete_users',
                'description' => 'Permission to delete users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'view_posts',
                'description' => 'Permission to view posts',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'create_posts',
                'description' => 'Permission to create posts',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'edit_posts',
                'description' => 'Permission to edit posts',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'delete_posts',
                'description' => 'Permission to delete posts',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more permissions as needed
        ]);
    }
}
