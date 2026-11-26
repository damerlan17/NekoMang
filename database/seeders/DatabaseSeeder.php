<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        if (!app()->environment('local', 'testing')) {
            return;
        }

        $this->call([
            UserSeeder::class,
            GenreSeeder::class,
            MangaSeeder::class,
            ChapterSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}
