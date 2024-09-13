<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Technology',
                'description' => 'All about the latest in technology.',
                'parent_id' => null,
                'slug' => Str::slug('Technology'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Programming',
                'description' => 'Resources and articles about programming.',
                'parent_id' => 1, // Assuming 'Technology' has ID 1
                'slug' => Str::slug('Programming'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lifestyle',
                'description' => 'Tips and articles about lifestyle.',
                'parent_id' => null,
                'slug' => Str::slug('Lifestyle'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
