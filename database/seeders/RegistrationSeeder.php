<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $firstNamesMale = ['Ahmad', 'Budi', 'Chandra', 'Dedi', 'Eko', 'Fajar', 'Guntur', 'Hendra', 'Irfan', 'Joko', 'Kevin', 'Lukman', 'Muhammad', 'Nugroho', 'Oki', 'Prabowo', 'Rian', 'Setyo', 'Taufik', 'Utomo', 'Wawan', 'Yudi'];
        $lastNamesMale  = ['Saputra', 'Wibowo', 'Kusuma', 'Santoso', 'Pratama', 'Hidayat', 'Gunawan', 'Wijaya', 'Setyawan', 'Nugraha', 'Raharjo', 'Setiawan', 'Budiman', 'Siregar', 'Lubis'];

        $firstNamesFemale = ['Anisa', 'Bunga', 'Citra', 'Dewi', 'Elisa', 'Fitri', 'Gita', 'Hani', 'Indah', 'Juli', 'Kartika', 'Laras', 'Mega', 'Novi', 'Olivia', 'Putri', 'Rini', 'Siti', 'Tari', 'Utami', 'Wulan', 'Yanti'];
        $lastNamesFemale  = ['Lestari', 'Sari', 'Indah', 'Rahmawati', 'Putri', 'Hartati', 'Kartika', 'Utami', 'Pertiwi', 'Wulandari', 'Anggraini', 'Safitri', 'Agustina'];

        $jerseySizes     = ['S', 'M', 'L', 'XL', 'XXL'];
        $paymentStatuses = ['lunas', 'lunas', 'lunas', 'lunas', 'pending', 'gagal'];

        // Clean existing registrations and peserta users
        Registration::query()->delete();
        User::where('role', 'peserta')->delete();

        $events = Event::with('runCategories')->get();

        if ($events->isEmpty()) {
            return;
        }

        foreach ($events as $event) {
            $categories = $event->runCategories;
            $eventTotalTerisi = 0;
            $bibCounter = 1001;

            if ($categories->count() > 0) {
                foreach ($categories as $cat) {
                    $regCount = rand(15, 30);
                    $catTerisi = 0;

                    for ($i = 0; $i < $regCount; $i++) {
                        $gender = rand(0, 1) ? 'Laki-laki' : 'Perempuan';
                        if ($gender === 'Laki-laki') {
                            $fullName = $firstNamesMale[array_rand($firstNamesMale)] . ' ' . $lastNamesMale[array_rand($lastNamesMale)];
                        } else {
                            $fullName = $firstNamesFemale[array_rand($firstNamesFemale)] . ' ' . $lastNamesFemale[array_rand($lastNamesFemale)];
                        }

                        $email = strtolower(str_replace(' ', '.', $fullName)) . '.' . rand(100, 999) . '@example.com';
                        $nik   = '3404' . str_pad((string)rand(1, 999999999999), 12, '0', STR_PAD_LEFT);

                        $user = User::create([
                            'name'          => $fullName,
                            'email'         => $email,
                            'password'      => bcrypt('password'),
                            'role'          => 'peserta',
                            'nik'           => $nik,
                            'no_hp'         => '08' . rand(11, 19) . rand(10000000, 99999999),
                            'jenis_kelamin' => $gender,
                            'ukuran_jersey' => $jerseySizes[array_rand($jerseySizes)],
                        ]);

                        $statusBayar = $paymentStatuses[array_rand($paymentStatuses)];

                        $bib = null;
                        if ($statusBayar === 'lunas') {
                            $prefix = strtoupper(substr($cat->nama, 0, 3));
                            $bib = $prefix . '-' . $event->id . '-' . $bibCounter++;
                            $catTerisi++;
                            $eventTotalTerisi++;
                        }

                        $eventDate = Carbon::parse($event->tanggal);
                        $minDate   = Carbon::now()->subMonths(3);
                        $maxDate   = $eventDate->isPast() ? $eventDate : Carbon::now();
                        if ($minDate->gt($maxDate)) {
                            $minDate = $maxDate->copy()->subDays(5);
                        }

                        $createdTimestamp = rand($minDate->timestamp, $maxDate->timestamp);
                        $createdAt        = Carbon::createFromTimestamp($createdTimestamp);

                        $nominal = $cat->harga;
                        $diskon  = (rand(1, 5) === 1) ? 25000 : 0; // 20% chance diskon
                        $total   = max($nominal + 5000 - $diskon, 0);

                        Registration::create([
                            'event_id'              => $event->id,
                            'event_run_category_id' => $cat->id,
                            'user_id'               => $user->id,
                            'no_bib'                => $bib,
                            'nama_lengkap'          => $fullName,
                            'email'                 => $email,
                            'no_hp'                 => $user->no_hp,
                            'nik'                   => $nik,
                            'jenis_kelamin'         => $gender,
                            'ukuran_jersey'         => $user->ukuran_jersey,
                            'kode_kupon'            => $diskon > 0 ? 'PROMOJOGJA' : null,
                            'nominal_bayar'         => $nominal,
                            'diskon'                => $diskon,
                            'total_bayar'           => $total,
                            'status_bayar'          => $statusBayar,
                            'created_at'            => $createdAt,
                            'updated_at'            => $createdAt,
                        ]);
                    }

                    $cat->update(['terisi' => $catTerisi]);
                }
            } else {
                // Event tanpa multi-kategori (legacy)
                $regCount = rand(20, 40);
                for ($i = 0; $i < $regCount; $i++) {
                    $gender = rand(0, 1) ? 'Laki-laki' : 'Perempuan';
                    $fullName = $gender === 'Laki-laki'
                        ? $firstNamesMale[array_rand($firstNamesMale)] . ' ' . $lastNamesMale[array_rand($lastNamesMale)]
                        : $firstNamesFemale[array_rand($firstNamesFemale)] . ' ' . $lastNamesFemale[array_rand($lastNamesFemale)];

                    $email = strtolower(str_replace(' ', '.', $fullName)) . '.' . rand(100, 999) . '@example.com';
                    $nik   = '3404' . str_pad((string)rand(1, 999999999999), 12, '0', STR_PAD_LEFT);

                    $user = User::create([
                        'name'          => $fullName,
                        'email'         => $email,
                        'password'      => bcrypt('password'),
                        'role'          => 'peserta',
                        'nik'           => $nik,
                        'no_hp'         => '08' . rand(11, 19) . rand(10000000, 99999999),
                        'jenis_kelamin' => $gender,
                        'ukuran_jersey' => $jerseySizes[array_rand($jerseySizes)],
                    ]);

                    $statusBayar = $paymentStatuses[array_rand($paymentStatuses)];

                    $bib = null;
                    if ($statusBayar === 'lunas') {
                        $bib = 'RUN-' . $event->id . '-' . $bibCounter++;
                        $eventTotalTerisi++;
                    }

                    $nominal = $event->harga;
                    $diskon  = 0;
                    $total   = max($nominal + 5000 - $diskon, 0);

                    Registration::create([
                        'event_id'              => $event->id,
                        'event_run_category_id' => null,
                        'user_id'               => $user->id,
                        'no_bib'                => $bib,
                        'nama_lengkap'          => $fullName,
                        'email'                 => $email,
                        'no_hp'                 => $user->no_hp,
                        'nik'                   => $nik,
                        'jenis_kelamin'         => $gender,
                        'ukuran_jersey'         => $user->ukuran_jersey,
                        'kode_kupon'            => null,
                        'nominal_bayar'         => $nominal,
                        'diskon'                => $diskon,
                        'total_bayar'           => $total,
                        'status_bayar'          => $statusBayar,
                    ]);
                }
            }

            $event->update(['terisi' => $eventTotalTerisi]);
        }
    }
}
