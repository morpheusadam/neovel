<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;

class CMSDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Call each seeder class to seed the respective tables
        $this->call([
            CategoriesTableSeeder::class,
            TagsTableSeeder::class,
            PostsTableSeeder::class,
            CommentsTableSeeder::class,
            PostTagsTableSeeder::class,
            PostMetaTableSeeder::class,
            PagesTableSeeder::class,
        ]);
    }
}
