<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_access_registration_form_for_past_event()
    {
        $user = User::factory()->create();
        $event = Event::create([
            'nama' => 'Lari Pagi',
            'kota' => 'Jakarta',
            'kategori' => '5K',
            'jarak_km' => 5,
            'tanggal' => today()->subDays(2), // Past
            'waktu_mulai' => '06:00:00',
            'harga' => 100000,
            'kuota' => 10,
            'terisi' => 0,
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($user)->get(route('events.register', $event));

        $response->assertRedirect(route('events.show', $event));
        $response->assertSessionHas('error', 'Pendaftaran gagal. Event ini sudah berlalu.');
    }

    public function test_cannot_register_for_past_event()
    {
        $user = User::factory()->create();
        $event = Event::create([
            'nama' => 'Lari Sore',
            'kota' => 'Bandung',
            'kategori' => '10K',
            'jarak_km' => 10,
            'tanggal' => today()->subDays(1), // Past
            'waktu_mulai' => '16:00:00',
            'harga' => 150000,
            'kuota' => 10,
            'terisi' => 0,
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($user)->post(route('events.register.store', $event), [
            'nama_lengkap' => 'Runner Test',
            'email' => 'runner@test.com',
            'no_hp' => '08123456789',
            'nik' => '1234567890123456',
            'jenis_kelamin' => 'Laki-laki',
            'ukuran_jersey' => 'L',
        ]);

        $response->assertRedirect(route('events.show', $event));
        $response->assertSessionHas('error', 'Pendaftaran gagal. Event ini sudah berlalu.');
    }

    public function test_cannot_access_registration_form_for_full_event()
    {
        $user = User::factory()->create();
        $event = Event::create([
            'nama' => 'Lari Malam',
            'kota' => 'Surabaya',
            'kategori' => '10K',
            'jarak_km' => 10,
            'tanggal' => today()->addDays(5), // Future
            'waktu_mulai' => '19:00:00',
            'harga' => 200000,
            'kuota' => 10,
            'terisi' => 10, // Full
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($user)->get(route('events.register', $event));

        $response->assertRedirect(route('events.show', $event));
        $response->assertSessionHas('error', 'Pendaftaran gagal. Kuota event ini sudah penuh.');
    }

    public function test_cannot_register_for_full_event()
    {
        $user = User::factory()->create();
        $event = Event::create([
            'nama' => 'Marathon Akbar',
            'kota' => 'Yogyakarta',
            'kategori' => 'Full Marathon',
            'jarak_km' => 42.2,
            'tanggal' => today()->addDays(10), // Future
            'waktu_mulai' => '05:00:00',
            'harga' => 500000,
            'kuota' => 50,
            'terisi' => 50, // Full
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($user)->post(route('events.register.store', $event), [
            'nama_lengkap' => 'Runner Test',
            'email' => 'runner@test.com',
            'no_hp' => '08123456789',
            'nik' => '1234567890123456',
            'jenis_kelamin' => 'Laki-laki',
            'ukuran_jersey' => 'L',
        ]);

        $response->assertRedirect(route('events.show', $event));
        $response->assertSessionHas('error', 'Pendaftaran gagal. Kuota event ini sudah penuh.');
    }

    public function test_can_register_for_active_and_available_event()
    {
        $user = User::factory()->create();
        $event = Event::create([
            'nama' => 'Half Marathon',
            'kota' => 'Jakarta',
            'kategori' => 'Half Marathon',
            'jarak_km' => 21.1,
            'tanggal' => today()->addDays(2), // Future
            'waktu_mulai' => '05:30:00',
            'harga' => 300000,
            'kuota' => 100,
            'terisi' => 50,
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($user)->post(route('events.register.store', $event), [
            'nama_lengkap' => 'Runner Test',
            'email' => 'runner@test.com',
            'no_hp' => '08123456789',
            'nik' => '1234567890123456',
            'jenis_kelamin' => 'Laki-laki',
            'ukuran_jersey' => 'L',
        ]);

        $response->assertRedirect(route('registrations.index'));
        $response->assertSessionHas('success');
        $this->assertEquals(51, $event->fresh()->terisi);
    }

    public function test_cannot_register_twice_with_same_nik_on_same_event()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $event = Event::create([
            'nama' => 'Fun Run Jogja',
            'kota' => 'Yogyakarta',
            'kategori' => '5K',
            'jarak_km' => 5,
            'tanggal' => today()->addDays(15),
            'waktu_mulai' => '06:00:00',
            'harga' => 100000,
            'kuota' => 100,
            'terisi' => 0,
            'status' => 'aktif',
        ]);

        // Pendaftaran 1 sukses
        $this->actingAs($user1)->post(route('events.register.store', $event), [
            'nama_lengkap' => 'Pelari Pertama',
            'email' => 'pelari1@test.com',
            'no_hp' => '081234567891',
            'nik' => '3404123456789012',
            'jenis_kelamin' => 'Laki-laki',
            'ukuran_jersey' => 'M',
        ])->assertRedirect(route('registrations.index'));

        // Pendaftaran 2 dengan NIK sama persis di event yang sama -> gagal
        $response = $this->actingAs($user2)->post(route('events.register.store', $event), [
            'nama_lengkap' => 'Pelari Kedua',
            'email' => 'pelari2@test.com',
            'no_hp' => '081234567892',
            'nik' => '3404123456789012', // Same NIK
            'jenis_kelamin' => 'Perempuan',
            'ukuran_jersey' => 'S',
        ]);

        $response->assertSessionHasErrors('nik');
        $this->assertEquals(1, Registration::where('event_id', $event->id)->count());
    }

    public function test_user_already_registered_cannot_access_form_again()
    {
        $user = User::factory()->create(['nik' => '3404987654321098']);
        $event = Event::create([
            'nama' => '10K Solo',
            'kota' => 'Solo',
            'kategori' => '10K',
            'jarak_km' => 10,
            'tanggal' => today()->addDays(20),
            'waktu_mulai' => '06:00:00',
            'harga' => 150000,
            'kuota' => 100,
            'terisi' => 1,
            'status' => 'aktif',
        ]);

        Registration::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'nama_lengkap' => $user->name,
            'email' => $user->email,
            'no_hp' => '08123456789',
            'nik' => '3404987654321098',
            'jenis_kelamin' => 'Laki-laki',
            'ukuran_jersey' => 'L',
            'total_bayar' => 155000,
            'status_bayar' => 'lunas',
        ]);

        // Coba akses form lagi -> ter-redirect ke detail event dengan error session
        $response = $this->actingAs($user)->get(route('events.register', $event));
        $response->assertRedirect(route('events.show', $event));
        $response->assertSessionHas('error');
    }

    public function test_same_user_cannot_register_with_different_nik()
    {
        $user = User::factory()->create();
        $event = Event::create([
            'nama' => 'Fun Run Semarang',
            'kota' => 'Semarang',
            'kategori' => '5K',
            'jarak_km' => 5,
            'tanggal' => today()->addDays(10),
            'waktu_mulai' => '06:00:00',
            'harga' => 100000,
            'kuota' => 100,
            'terisi' => 0,
            'status' => 'aktif',
        ]);

        // Pendaftaran pertama berhasil
        $this->actingAs($user)->post(route('events.register.store', $event), [
            'nama_lengkap' => $user->name,
            'email' => $user->email,
            'no_hp' => '081234567890',
            'nik' => '3404111111111111',
            'jenis_kelamin' => 'Laki-laki',
            'ukuran_jersey' => 'M',
        ])->assertRedirect(route('registrations.index'));

        // Akun SAMA coba daftar lagi dengan NIK BERBEDA -> harus GAGAL
        $response = $this->actingAs($user)->post(route('events.register.store', $event), [
            'nama_lengkap' => $user->name,
            'email' => $user->email,
            'no_hp' => '081234567890',
            'nik' => '3404222222222222', // NIK berbeda
            'jenis_kelamin' => 'Laki-laki',
            'ukuran_jersey' => 'M',
        ]);

        $response->assertSessionHasErrors('nik');
        $this->assertEquals(1, Registration::where('event_id', $event->id)->count());
    }
}
