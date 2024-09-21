<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'role_name' => 'Admin',
                'description' => 'Administrator with full access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'Editor',
                'description' => 'Editor with access to content management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'User',
                'description' => 'Regular user with limited access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'Chef',
                'description' => 'Chef with access to kitchen management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'HeadChef',
                'description' => 'Head Chef with full access to kitchen management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'ParkingManager',
                'description' => 'Manager responsible for parking management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'Staff',
                'description' => 'General staff with limited access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'Salesperson',
                'description' => 'Salesperson with access to sales management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'BlogManager',
                'description' => 'Manager responsible for blog content',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'WebsiteManager',
                'description' => 'Manager responsible for website content',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'CustomerManager',
                'description' => 'Manager responsible for customer relations',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'Accountant',
                'description' => 'Accountant responsible for financial management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more roles as needed
        ]);
    }
}
