<?php

namespace Database\Seeders;

use App\Models\Category as ModelsCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Category extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsCategory::factory()
            ->count(10)
            ->create();
    }
}
