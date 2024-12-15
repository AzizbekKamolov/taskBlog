<?php

namespace Database\Seeders;

use App\Models\ArticleModel;
use App\Models\TagModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TagModel::factory()->count(15)->create();
    }
}
