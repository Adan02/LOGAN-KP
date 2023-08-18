<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Modul>
 */
class ModulFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vendor' => Arr::random(['TELLABS', 'CISCO', 'ALCATEL', 'AVAGO', 'FINISAR', 'HUAWEI', 'INNO LIGHT', 'JDSU', 'JUNIPER', 'NEOPHOTONICS', 'OPNEXT', 'OPTONE', 'SUMITIMO']), 
            'tipe_board' => Arr::random(['LPUF 22-A', 'LPUF 40-A', 'LPUF 200', 'LPUF 120', 'LPUF 240']), 
            'serial_number' => uniqid(), 
            // 'tanggal_masuk' => fake()->dateTimeBetween('-4 months', '-3 months'),
            // 'bkeluar_id' => Arr::random([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30]),
            // 'hasil' => Arr::random(['BAIK', 'KURANG BAIK', 'BURUK'])
            'tanggal_masuk' => fake()->dateTimeBetween('-3 months', '-2 months'),
        ];
    }
}
