<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_profile_page_is_displayed(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($admin)
            ->get('/admin/profile');

        $response->assertOk();
    }

    public function test_non_admin_cannot_access_admin_profile(): void
    {
        $user = User::factory()->create([
            'role' => 'peserta',
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/admin/profile');

        $response->assertForbidden();
    }

    public function test_admin_profile_information_can_be_updated(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $avatar = UploadedFile::fake()->image('admin_avatar.jpg');

        $response = $this
            ->actingAs($admin)
            ->patch('/admin/profile', [
                'name' => 'Admin Utama',
                'email' => 'admin.utama@maurun.test',
                'nik' => '9876543210123456',
                'no_hp' => '089876543210',
                'jenis_kelamin' => 'Laki-laki',
                'ukuran_jersey' => 'L',
                'avatar' => $avatar,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/admin/profile');

        $admin->refresh();

        $this->assertSame('Admin Utama', $admin->name);
        $this->assertSame('admin.utama@maurun.test', $admin->email);
        $this->assertSame('9876543210123456', $admin->nik);
        $this->assertSame('089876543210', $admin->no_hp);
        $this->assertSame('Laki-laki', $admin->jenis_kelamin);
        $this->assertSame('L', $admin->ukuran_jersey);
        $this->assertNotNull($admin->avatar);

        Storage::disk('public')->assertExists($admin->avatar);
    }
}
