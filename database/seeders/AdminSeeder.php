<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Membuat (atau memperbarui) akun admin dari config/admin.php (ADMIN_*).
 * Aman dijalankan berulang: akun dicari berdasarkan email.
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.email');

        if (blank($email)) {
            $this->command?->warn('ADMIN_EMAIL kosong — akun admin tidak dibuat.');

            return;
        }

        $user = User::firstOrNew(['email' => $email]);
        $password = config('admin.password');
        $generated = null;

        // Kata sandi hanya diisi untuk akun baru. Akun yang sudah ada tidak disentuh, kecuali
        // ADMIN_RESET_PASSWORD=true — supaya `db:seed` di deploy tidak mengembalikan sandi lama.
        if (! $user->exists || config('admin.reset_password')) {
            if (filled($password)) {
                $user->password = $password;
            } else {
                $user->password = $generated = Str::password(16);
            }
        }

        $user->forceFill([
            'name' => $user->name ?? config('admin.name'),
            'email_verified_at' => $user->email_verified_at ?? now(),
            'is_admin' => true,
        ])->save();

        $this->command?->info("Akun admin siap: {$email}");

        if ($generated !== null) {
            $this->command?->warn("Kata sandi acak (simpan sekarang, tidak ditampilkan lagi): {$generated}");
        }
    }
}
