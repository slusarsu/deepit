<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::query()->create([
            'title' => 'Tag 1',
            'slug' => 'Tag-1',
        ]);

        Tag::query()->create([
            'title' => 'Tag 2',
            'slug' => 'Tag-2',
        ]);

        Tag::query()->create([
            'title' => 'Tag 3',
            'slug' => 'Tag-3',
        ]);

        Tag::query()->create([
            'title' => 'Tag 4',
            'slug' => 'Tag-4',
        ]);

        Tag::query()->create([
            'title' => 'Tag 5',
            'slug' => 'Tag-5',
        ]);

        $posts = Post::all();

        foreach ($posts as $post) {
            $random = rand(1,5);
            $post->tags()->attach($random);
        }
    }
}
