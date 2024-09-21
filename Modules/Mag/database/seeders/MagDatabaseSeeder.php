<?php

namespace Modules\Mag\Database\Seeders;

use Illuminate\Database\Seeder;

class MagDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
