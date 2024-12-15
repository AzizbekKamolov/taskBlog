<?php

namespace Database\Seeders;

use App\Models\ArticleModel;
use App\Models\TagModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            $tag = TagModel::query()->inRandomOrder()->limit(rand(3, 5))->get();
            $title = fake()->sentence();
            $article = ArticleModel::query()->create([
                'photo' => fake()->imageUrl(),
                'title' => $title,
                'slug' => Str::slug($title),
                'short_content' => fake()->text(100),
                'content' => fake()->text(),
                'liked' => rand(100, 500),
                'showed' => rand(100, 500),
            ]);
            $article->tags()->attach($tag->pluck('id')->toArray());
            $article->update([
                'slug' => $article->slug . '-' . $article->id,
            ]);
        }
    }
}
