<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_roles')->insert([
            [
                'user_id' => 1,
                'role_id' => 1, // Assuming 1 is the ID for Admin role
            ],
            [
                'user_id' => 2,
                'role_id' => 2, // Assuming 2 is the ID for Editor role
            ],
            // Add more user-role relationships as needed
        ]);
    }
}
