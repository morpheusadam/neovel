<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            UserRolesTableSeeder::class,
            RolePermissionsTableSeeder::class,
            UserMetaTableSeeder::class, // Add this line
        ]);
    }
}
