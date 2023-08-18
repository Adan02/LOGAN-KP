<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patchcord>
 */
class PatchcordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jenis' => Arr::random(['Single Mode', 'Multimode']),
            'konektor' => Arr::random(['FC-FC', 'FC-LC', 'FC-SC', 'LC-FC', 'LC-LC', 'LC-SC', 'SC-FC', 'SC-LC', 'SC-SC']), 
            'jarak' => Arr::random([1, 5, 10, 15, 20, 25, 30, 40]), 
            'tipe_kabel' => Arr::random(['Simplex', 'Duplex']),
            'serial_number' => uniqid(),
            // 'tanggal_masuk' => fake()->dateTimeBetween('-4 months', '-3 months'),
            // 'bkeluar_id' => Arr::random([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30]),
            // 'hasil' => Arr::random(['BAIK', 'KURANG BAIK', 'BURUK'])
            'tanggal_masuk' => fake()->dateTimeBetween('-3 months', '-2 months'),
        ];
    }
}
