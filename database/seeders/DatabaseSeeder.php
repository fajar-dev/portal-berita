<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ArticleSeeder::class,
            VideoStorySeeder::class,
            OpinionSeeder::class,
            InfographicSeeder::class,
            SettingSeeder::class,
            CommentSeeder::class,
            PollSeeder::class,
            TagSeeder::class,
            MenuSeeder::class,
            PageSeeder::class,
        ]);
    }
}
