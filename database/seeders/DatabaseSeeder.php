<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        app()->call(UserSeeder::class);
        app()->call(PageSeeder::class);
//        Post::factory(33)->create();
//        app()->call(CategorySeeder::class);
//        app()->call(TagSeeder::class);
        app()->call(AdmFormSeeder::class);
    }

    public function sleep()
    {
        sleep(1);
    }
}
