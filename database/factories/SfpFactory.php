<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SfpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenis = Arr::random(['SFP', 'SFP+', 'XFP', 'QSFP']);
        $jarak = Arr::random([10, 40, 80]);

        if ($jenis === 'SFP'){
            $bandwidth = 1;
        }
        elseif ($jenis === 'SFP+' || $jenis === 'XFP'){
            $bandwidth = 10;
        }else{
            $bandwidth = 100;
        }

        if ($jarak === 10){
            $lambda = 1310;
        }else{
            $lambda = 1550;
        }

        return [
            'jenis' => $jenis,
            'vendor' => Arr::random(['TELLABS', 'CISCO', 'ALCATEL', 'AVAGO', 'FINISAR', 'HUAWEI', 'INNO LIGHT', 'JDSU', 'JUNIPER', 'NEOPHOTONICS', 'OPNEXT', 'OPTONE', 'SUMITIMO']),
            'bandwidth' => $bandwidth,
            'lambda' => $lambda,
            'jarak' => $jarak,
            'serial_number' => uniqid(),
            // 'tanggal_masuk' => fake()->dateTimeBetween('-4 months', '-3 months'),
            // 'bkeluar_id' => Arr::random([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30]),
            // 'hasil' => Arr::random(['BAIK', 'KURANG BAIK', 'BURUK'])
            'tanggal_masuk' => fake()->dateTimeBetween('-3 months', '-2 months'),
        ];
    }
}
