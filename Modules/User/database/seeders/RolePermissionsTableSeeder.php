<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_permissions')->insert([
            [
                'role_id' => 1, // Assuming 1 is the ID for Admin role
                'permission_id' => 1, // Ensure this ID exists in the permissions table
            ],
            [
                'role_id' => 1,
                'permission_id' => 2, // Ensure this ID exists in the permissions table
            ],
            [
                'role_id' => 2, // Assuming 2 is the ID for Editor role
                'permission_id' => 3, // Ensure this ID exists in the permissions table
            ],
            // Add more role-permission relationships as needed
        ]);
    }
}
