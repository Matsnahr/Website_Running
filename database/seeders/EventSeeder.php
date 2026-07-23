<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventFacility;
use App\Models\EventRunCategory;
use App\Models\Coupon;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'nama'        => 'Grow Run 2026',
                'kota'        => 'Yogyakarta',
                'kategori'    => 'Full Marathon',
                'jarak_km'    => 42.2,
                'tanggal'     => '2026-08-15',
                'waktu_mulai' => '05:00',
                'harga'       => 150000,
                'kuota'       => 3500,
                'terisi'      => 0,
                'status'      => 'aktif',
                'deskripsi'   => "Rasakan sensasi berlari melintasi keindahan budaya dan keramahan kota Yogyakarta.\n\nLintasan lari didesain khusus melewati ikon-ikon bersejarah seperti Tugu Jogja, Malioboro, dan kawasan benteng Vredeburg. Tersedia pilihan kategori dari Fun Run hingga Full Marathon!",
                'facilities'  => ['Jersey Balapan Premium', 'Medali Finisher Eksklusif', 'Bib & Timing Chip', 'Hydration & Fruit Station', 'Asuransi Peserta (Proteksi Lari)'],
                'run_categories' => [
                    ['nama' => 'Fun Run 5K',     'jarak_km' => 5.0,  'harga' => 150000, 'kuota' => 1000, 'terisi' => 0, 'urutan' => 0, 'deskripsi' => 'Rute santai cocok untuk keluarga & pemula'],
                    ['nama' => 'Half Marathon',  'jarak_km' => 21.1, 'harga' => 250000, 'kuota' => 1500, 'terisi' => 0, 'urutan' => 1, 'deskripsi' => 'Rute menengah melintasi jantung kota Jogja'],
                    ['nama' => 'Full Marathon',  'jarak_km' => 42.2, 'harga' => 400000, 'kuota' => 1000, 'terisi' => 0, 'urutan' => 2, 'deskripsi' => 'Tantangan endurance penuh 42.195 KM'],
                ],
            ],
            [
                'nama'        => 'H Run 2026',
                'kota'        => 'Yogyakarta',
                'kategori'    => '5K',
                'jarak_km'    => 5.0,
                'tanggal'     => '2026-09-28',
                'waktu_mulai' => '06:00',
                'harga'       => 75000,
                'kuota'       => 1000,
                'terisi'      => 0,
                'status'      => 'aktif',
                'deskripsi'   => 'Lari santai bersama komunitas H Run. Jalur sejuk dan rindang di kawasan utara Yogyakarta.',
                'facilities'  => ['Jersey Komunitas', 'Medali Finisher', 'Refreshment & Isotonik', 'Foto Dokumentasi HD'],
                'run_categories' => [
                    ['nama' => '3K Santai',  'jarak_km' => 3.0,  'harga' => 75000,  'kuota' => 300, 'terisi' => 0, 'urutan' => 0, 'deskripsi' => 'Lari / jalan santai tanpa batas waktu'],
                    ['nama' => '5K',         'jarak_km' => 5.0,  'harga' => 100000, 'kuota' => 500, 'terisi' => 0, 'urutan' => 1, 'deskripsi' => 'Kategori terpopuler untuk pelari hobi'],
                    ['nama' => '10K Challenge','jarak_km' => 10.0,'harga' => 150000, 'kuota' => 200, 'terisi' => 0, 'urutan' => 2, 'deskripsi' => 'Uji ketahanan fisik di rute 10 kilometer'],
                ],
            ],
            [
                'nama'        => 'HRSIY PDHI Fun Run',
                'kota'        => 'Jakarta',
                'kategori'    => '10K',
                'jarak_km'    => 10.0,
                'tanggal'     => '2026-10-08',
                'waktu_mulai' => '05:00',
                'harga'       => 300000,
                'kuota'       => 5000,
                'terisi'      => 0,
                'status'      => 'aktif',
                'deskripsi'   => "Rasakan sensasi berlari di jantung kota Jakarta dalam event bergengsi HRSIY PDHI Fun Run.\n\nRute ini membawa Anda melewati landmark ikonik, dimulai dari Monumen Nasional (Monas) dan melintasi kawasan bisnis pusat Sudirman-Thamrin sebelum berakhir kembali di alun-alun bersejarah.\n\nLintasan tersertifikasi ini datar dan cepat, sangat cocok untuk mencetak rekor pribadi (Personal Best).",
                'facilities'  => ['Jersey Dri-Fit Premium', 'Medali Finisher Metalik', 'Race Drawstring Bag', 'Timing Chip Tag', 'Goodie Bag Sponsor', 'Medis & Ambulans Standby'],
                'run_categories' => [
                    ['nama' => '5K Fun Run',   'jarak_km' => 5.0,  'harga' => 300000, 'kuota' => 2000, 'terisi' => 0, 'urutan' => 0, 'deskripsi' => 'Lari santai kawasan Monas & Thamrin'],
                    ['nama' => '10K Speed Run', 'jarak_km' => 10.0, 'harga' => 450000, 'kuota' => 2000, 'terisi' => 0, 'urutan' => 1, 'deskripsi' => 'Lintasan datar tersertifikasi untuk personal best'],
                    ['nama' => '21K Half Marathon','jarak_km' => 21.1,'harga' => 600000, 'kuota' => 1000, 'terisi' => 0, 'urutan' => 2, 'deskripsi' => 'Tantangan 21 KM melintasi Sudirman-Kuningan'],
                ],
            ],
            [
                'nama'        => 'Sae Run',
                'kota'        => 'Probolinggo',
                'kategori'    => '3K',
                'jarak_km'    => 3.0,
                'tanggal'     => '2026-11-08',
                'waktu_mulai' => '06:00',
                'harga'       => 100000,
                'kuota'       => 2000,
                'terisi'      => 0,
                'status'      => 'aktif',
                'deskripsi'   => 'Lari komunitas santai di Probolinggo. Pemandangan pantai dan angin laut sejuk sepanjang lintasan.',
                'facilities'  => ['Kaos Lari Sae Run', 'Medali Finisher Kayu Unik', 'Snack & Es Kelapa Muda'],
                'run_categories' => [
                    ['nama' => '3K Kids & Family', 'jarak_km' => 3.0,  'harga' => 100000, 'kuota' => 500,  'terisi' => 0, 'urutan' => 0, 'deskripsi' => 'Kategori ramah anak dan keluarga'],
                    ['nama' => '5K Fun',           'jarak_km' => 5.0,  'harga' => 150000, 'kuota' => 1000, 'terisi' => 0, 'urutan' => 1, 'deskripsi' => 'Kategori umum rute pesisir'],
                    ['nama' => '10K Challenge',    'jarak_km' => 10.0, 'harga' => 250000, 'kuota' => 500,  'terisi' => 0, 'urutan' => 2, 'deskripsi' => 'Kategori kompetitif lokal'],
                ],
            ],
        ];

        foreach ($events as $data) {
            $runCategories = $data['run_categories'] ?? [];
            $facilities    = $data['facilities'] ?? [];
            unset($data['run_categories'], $data['facilities']);

            $event = Event::create($data);

            // Create Run Categories
            foreach ($runCategories as $rc) {
                EventRunCategory::create([
                    'event_id'  => $event->id,
                    'nama'      => $rc['nama'],
                    'jarak_km'  => $rc['jarak_km'],
                    'harga'     => $rc['harga'],
                    'kuota'     => $rc['kuota'],
                    'terisi'    => 0,
                    'deskripsi' => $rc['deskripsi'] ?? null,
                    'urutan'    => $rc['urutan'],
                ]);
            }

            // Create Facilities
            foreach ($facilities as $facName) {
                EventFacility::create([
                    'event_id'       => $event->id,
                    'nama_fasilitas' => $facName,
                ]);
            }
        }

        // Seed Sample Coupons
        $coupons = [
            [
                'code'          => 'MAURUN2026',
                'discount'      => 50000,
                'discount_type' => 'nominal',
                'expired_at'    => '2026-12-31',
                'is_active'     => true,
            ],
            [
                'code'          => 'DISKON10P',
                'discount'      => 10,
                'discount_type' => 'percentage',
                'expired_at'    => '2026-12-31',
                'is_active'     => true,
            ],
            [
                'code'          => 'PROMOJOGJA',
                'discount'      => 25000,
                'discount_type' => 'nominal',
                'expired_at'    => '2026-12-31',
                'is_active'     => true,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::updateOrCreate(
                ['code' => $coupon['code']],
                $coupon
            );
        }
    }
}