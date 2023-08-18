<?php

namespace Database\Seeders;

use App\Models\BKeluar;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BKeluarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BKeluar::factory()->count(30)->create();
    }
}
