<?php

namespace Database\Seeders;

use App\Models\Post as ModelsPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Post extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsPost::factory()->count(4)->create();
    }
}
