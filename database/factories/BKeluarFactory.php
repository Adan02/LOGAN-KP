<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BKeluarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kebutuhan' => Arr::random(['Upgrade 10G MKS-PLP', 'Integrasi ME-D7-SLY', 'Peminjaman SFP untuk Engineering Inovasi BIT', 'SFP Huawei 1G 10KM', 'Upgrade Metro Malino dan Kanreapia']),
            'instansi_pemberi' => Arr::random(['Network Area and IS Operation Telkom Witel Makassar', 'MANAGER NETWORK AREA & IS OPERATION MAKASSAR', 'Telkom']),
            'nama_pemberi' => Arr::random(['Rifqi Fadhlillah', 'Valliant Ferlyando', 'Winggar']),
            'nik_pemberi' => Arr::random(['930369', '890073', '12312312123']),
            'instansi_penerima' => Arr::random(['BGES Operation', 'Regional Network Operation Telkom Regional VII', 'Wholesale Access Network Witel Makassar', 'Acess Maintenance & QE']),
            'nama_penerima' => Arr::random(['Fathurahman', 'Andi Afwan', 'Irfan Ramadhan Pramudita', 'Yan Salbin Syarif']),
            'nik_penerima' => Arr::random(['860042', '920168', '950078']),
            // 'hasil' => Arr::random(['BAIK', 'KURANG BAIK', 'BURUK']),
            'tanggal_keluar' => fake()->dateTimeBetween('-1 months')
        ];
    }
}
