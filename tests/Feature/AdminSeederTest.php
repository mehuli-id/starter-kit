<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_membuat_admin_dari_config(): void
    {
        config(['admin.name' => 'Admin Mehuli', 'admin.email' => 'admin@mehuli.test', 'admin.password' => 'rahasia-123']);

        $this->seed(AdminSeeder::class);

        $admin = User::where('email', 'admin@mehuli.test')->firstOrFail();
        $this->assertTrue($admin->is_admin);
        $this->assertSame('Admin Mehuli', $admin->name);
        $this->assertNotNull($admin->email_verified_at);
        $this->assertTrue(Hash::check('rahasia-123', $admin->password));
    }

    public function test_dilewati_tanpa_admin_email(): void
    {
        config(['admin.email' => null]);

        $this->seed(AdminSeeder::class);

        $this->assertDatabaseCount('users', 0);
    }

    public function test_membuat_kata_sandi_acak_tanpa_admin_password(): void
    {
        config(['admin.email' => 'admin@mehuli.test', 'admin.password' => null]);

        $this->seed(AdminSeeder::class);

        $admin = User::where('email', 'admin@mehuli.test')->firstOrFail();
        $this->assertFalse(Hash::check('', $admin->password));
        $this->assertTrue($admin->is_admin);
    }

    public function test_seeding_ulang_tidak_menimpa_kata_sandi_yang_sudah_diganti(): void
    {
        config(['admin.email' => 'admin@mehuli.test', 'admin.password' => null]);
        User::factory()->create(['email' => 'admin@mehuli.test', 'password' => 'sandi-baru', 'name' => 'Nama Lama']);

        $this->seed(AdminSeeder::class);

        $admin = User::where('email', 'admin@mehuli.test')->firstOrFail();
        $this->assertTrue(Hash::check('sandi-baru', $admin->password));
        $this->assertSame('Nama Lama', $admin->name);
        $this->assertTrue($admin->is_admin);
        $this->assertDatabaseCount('users', 1);
    }
}
