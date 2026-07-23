<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventRunCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiCategoryEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_multi_category_event(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.events.store'), [
            'nama'            => 'Lari Marathon Nusantara 2026',
            'kota'            => 'Bandung',
            'tanggal'         => now()->addDays(30)->format('Y-m-d'),
            'waktu_mulai'     => '05:30',
            'status'          => 'aktif',
            'deskripsi'       => 'Event lari dengan banyak pilihan kategori.',
            'run_categories'  => [
                ['nama' => '5K Fun',   'jarak_km' => 5,  'harga' => 150000, 'kuota' => 200, 'deskripsi' => 'Kategori santai'],
                ['nama' => '10K Race', 'jarak_km' => 10, 'harga' => 250000, 'kuota' => 300, 'deskripsi' => 'Kategori menengah'],
            ],
        ]);

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('events', ['nama' => 'Lari Marathon Nusantara 2026']);

        $event = Event::where('nama', 'Lari Marathon Nusantara 2026')->first();
        $this->assertCount(2, $event->runCategories);
        $this->assertEquals(150000, $event->harga); // harga min
        $this->assertEquals(500, $event->kuota);     // total kuota
    }

    public function test_user_can_select_one_category_when_registering(): void
    {
        $user  = User::factory()->create(['role' => 'peserta']);
        $event = Event::create([
            'nama'        => 'Jogja Marathon 2026',
            'kota'        => 'Yogyakarta',
            'kategori'    => 'Full Marathon',
            'jarak_km'    => 42.2,
            'tanggal'     => now()->addDays(20)->format('Y-m-d'),
            'waktu_mulai' => '05:00',
            'harga'       => 150000,
            'kuota'       => 500,
            'terisi'      => 0,
            'status'      => 'aktif',
        ]);

        $cat1 = EventRunCategory::create([
            'event_id' => $event->id,
            'nama'     => '5K',
            'jarak_km' => 5,
            'harga'    => 120000,
            'kuota'    => 200,
            'terisi'   => 0,
        ]);

        $cat2 = EventRunCategory::create([
            'event_id' => $event->id,
            'nama'     => '10K',
            'jarak_km' => 10,
            'harga'    => 200000,
            'kuota'    => 300,
            'terisi'   => 0,
        ]);

        $response = $this->actingAs($user)->post(route('events.register.store', $event), [
            'nama_lengkap'          => 'Budi Pelari',
            'email'                 => 'budi@example.com',
            'no_hp'                 => '081234567890',
            'nik'                   => '1234567890123456',
            'jenis_kelamin'         => 'Laki-laki',
            'ukuran_jersey'         => 'L',
            'event_run_category_id' => $cat2->id,
        ]);

        $response->assertRedirect(route('registrations.index'));
        $this->assertDatabaseHas('registrations', [
            'event_id'               => $event->id,
            'event_run_category_id'  => $cat2->id,
            'nik'                    => '1234567890123456',
            'total_bayar'            => 205000, // 200.000 + 5.000 layanan
        ]);

        $cat2->refresh();
        $this->assertEquals(1, $cat2->terisi);
    }
}
