<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use App\Models\EventCity;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Categories
        $categories = [
            ['nama' => '3K', 'jarak_km_default' => 3.0, 'urutan' => 1],
            ['nama' => '5K', 'jarak_km_default' => 5.0, 'urutan' => 2],
            ['nama' => '10K', 'jarak_km_default' => 10.0, 'urutan' => 3],
            ['nama' => 'Half Marathon', 'jarak_km_default' => 21.1, 'urutan' => 4],
            ['nama' => 'Full Marathon', 'jarak_km_default' => 42.2, 'urutan' => 5],
            ['nama' => 'Trail Run', 'jarak_km_default' => 15.0, 'urutan' => 6],
        ];

        foreach ($categories as $cat) {
            EventCategory::updateOrCreate(
                ['nama' => $cat['nama']],
                [
                    'jarak_km_default' => $cat['jarak_km_default'],
                    'urutan' => $cat['urutan'],
                    'aktif' => true,
                ]
            );
        }

        // 2. Seed Cities
        $citiesPath = public_path('cities.json');
        $cities = [];
        if (file_exists($citiesPath)) {
            $cities = json_decode(file_get_contents($citiesPath), true) ?: [];
        }

        if (empty($cities)) {
            $cities = [
                'Jakarta', 'Bandung', 'Surabaya', 'Semarang', 'Yogyakarta',
                'Malang', 'Solo', 'Bali', 'Medan', 'Makassar', 'Balikpapan'
            ];
        }

        foreach ($cities as $cityName) {
            EventCity::updateOrCreate(
                ['nama' => $cityName],
                ['aktif' => true]
            );
        }
    }
}
