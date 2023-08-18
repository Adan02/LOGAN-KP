<?php

namespace Database\Seeders;

use App\Models\Patchcord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatchcordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patchcord::factory()->count(1000)->create();
    }
}
