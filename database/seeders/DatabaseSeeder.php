<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Detail;
use App\Models\Image;
use App\Models\Map;
use App\Models\OperationalTime;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Category::factory()->count(5)->create();
        Map::factory()->count(5)->create();
        Detail::factory()->count(5)->create();
        Image::factory()->count(5)->create();
        OperationalTime::factory()->count(7)->create();
    }
}
