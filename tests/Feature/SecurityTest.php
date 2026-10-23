<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_header_keamanan_terpasang(): void
    {
        $response = $this->get(route('filament.admin.auth.login'));

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeaderMissing('X-Powered-By');
    }

    public function test_hsts_hanya_lewat_https(): void
    {
        $this->get('http://localhost/admin/login')->assertHeaderMissing('Strict-Transport-Security');
        $this->get('https://localhost/admin/login')->assertHeader('Strict-Transport-Security');
    }

    public function test_kata_sandi_lemah_ditolak(): void
    {
        foreach (['password', 'pendek1', 'hanyahurufsaja'] as $weak) {
            $this->assertTrue(Validator::make(['p' => $weak], ['p' => Password::default()])->fails(), $weak);
        }

        $this->assertFalse(Validator::make(['p' => 'tumbler-stainless-2026'], ['p' => Password::default()])->fails());
    }

    public function test_cookie_sesi_secure_di_production(): void
    {
        $this->assertTrue((bool) (require base_path('config/session.php'))['secure'] === (env('APP_ENV') === 'production'));
    }

    public function test_pengguna_biasa_tidak_bisa_membuka_halaman_tampilan(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('filament.admin.pages.appearance'))
            ->assertForbidden();
    }
}
