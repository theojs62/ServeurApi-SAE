<?php

namespace Database\Seeders;

use App\Models\Like;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class likeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Like::factory()->count(50)->create();
    }
}
