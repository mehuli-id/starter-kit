<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get(route('filament.admin.pages.dashboard'))
            ->assertRedirect(route('filament.admin.auth.login'));
    }

    public function test_halaman_login_bisa_dibuka(): void
    {
        $this->get(route('filament.admin.auth.login'))->assertOk();
    }

    public function test_admin_bisa_membuka_dasbor(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get(route('filament.admin.pages.dashboard'))
            ->assertOk();
    }

    public function test_pengguna_biasa_tidak_bisa_membuka_panel(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('filament.admin.pages.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_bisa_membuka_halaman_tampilan(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get(route('filament.admin.pages.appearance'))
            ->assertOk()
            ->assertSee(__('filament-shadcn::filament-shadcn.appearance.title'));
    }

    public function test_is_admin_tidak_bisa_diisi_massal(): void
    {
        $user = User::create([
            'name' => 'Staf',
            'email' => 'staf@example.com',
            'password' => 'password',
            'is_admin' => true,
        ]);

        $this->assertFalse($user->fresh()->is_admin);
    }
}
