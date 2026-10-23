# CLAUDE.md — mehuli/starter-kit

Starter kit (template repository) PT. Mehuli Data Media.

## Aturan kerja
- Balas dalam Bahasa Indonesia.
- Hindari hard-code: yang bisa berubah lewat config/.env/terjemahan (mis. `config/admin.php`, `config/filament-shadcn.php`).

## Stack
- Laravel 13, Filament 5, Livewire 4, Tailwind v4, PHPUnit.
- Tema: package privat `mehuli/filament-shadcn` (`^1.1.7`) dari repo `vcs` `mehuli-id/filament-shadcn`. Butuh token GitHub di composer.

## Struktur penting
- `config/admin.php` — `ADMIN_PANEL_PATH`, `ADMIN_NAME`, `ADMIN_EMAIL`, `ADMIN_PASSWORD`.
- `database/seeders/AdminSeeder.php` — buat/perbarui admin dari config; idempoten; tidak menimpa sandi kecuali `ADMIN_PASSWORD` diisi.
- `app/Models/User.php` — `FilamentUser`, `canAccessPanel()` = `is_admin`; `is_admin` tidak fillable.
- `app/Providers/Filament/AdminPanelProvider.php` — panel `admin`, `ShadcnPlugin` dengan `canCustomizeAppearance(is_admin)`, login `Mehuli\FilamentShadcn\Pages\Auth\Login`, profil `Pages\Auth\EditProfile` (di dalam panel), `databaseNotifications()` (tabel `notifications`).
- `config/app.php` — bawaan `id`, `id_ID`, `Asia/Jakarta` (bisa diubah lewat `.env`).
- `tests/TestCase.php` memanggil `withoutVite()`.

## Keamanan (jangan dilonggarkan)
- Jangan jadikan `is_admin` fillable.
- `canAccessPanel()` wajib ada; tanpa itu panel tertutup di production.

## Catatan
- `php artisan serve` mewarisi `APP_ENV` lama setelah `.env` diubah; restart penuh saat menguji production.
- Pesan validasi Laravel bawaan masih bahasa Inggris (teks Filament sudah `id`). Bila perlu, tambahkan `lang/id/*.php`.
