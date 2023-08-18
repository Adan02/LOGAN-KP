<?php

namespace Database\Seeders;

use App\Models\Sfp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SfpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sfp::factory()->count(1000)->create();
    }
}
