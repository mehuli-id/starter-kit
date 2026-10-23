# Mehuli Starter Kit

Titik awal proyek baru PT. Mehuli Data Media:

- **Laravel 13**, **Filament 5**, Livewire 4, Tailwind v4
- Tema **shadcn/ui** dari package privat [`mehuli/filament-shadcn`](https://github.com/mehuli-id/filament-shadcn) (`^1.1.5`): sidebar + header ala mockup, login "Selamat datang kembali", notifikasi database
- Bahasa Indonesia (`id`) dan zona waktu `Asia/Jakarta` sebagai bawaan
- Akun admin awal dari `.env` (`ADMIN_*`) lewat seeder
- Akses panel hanya untuk pengguna dengan `is_admin = true`
- Halaman **Tampilan** di panel (gaya, warna, tata letak), hanya untuk admin

## Mulai proyek baru

Repo ini adalah *template repository*:

```bash
gh repo create mehuli-id/nama-proyek --private --template mehuli-id/starter-kit --clone
cd nama-proyek
```

### Sekali per komputer/CI: akses ke package privat

```bash
composer config --global github-oauth.github.com <TOKEN>   # token dengan akses baca repo mehuli-id
```

### Pasang

```bash
cp .env.example .env
# isi APP_NAME, ADMIN_EMAIL, ADMIN_PASSWORD (opsional), dll.
composer setup
composer dev    # atau: php artisan serve
```

`composer setup` menjalankan: `composer install` → `key:generate` → `migrate` → `db:seed` → `storage:link` → `npm install` → `npm run build`.

Buka `http://localhost:8000/admin` dan masuk dengan `ADMIN_EMAIL`.

## Pengaturan (.env)

| Variabel | Bawaan | Keterangan |
|---|---|---|
| `APP_NAME` | `Mehuli App` | juga nama merek di panel |
| `APP_LOCALE` / `APP_FAKER_LOCALE` | `id` / `id_ID` | |
| `APP_TIMEZONE` | `Asia/Jakarta` | |
| `ADMIN_PANEL_PATH` | `admin` | URL panel |
| `ADMIN_NAME` | `Administrator` | |
| `ADMIN_EMAIL` | — | kosong → seeder tidak membuat admin |
| `ADMIN_PASSWORD` | — | kosong → kata sandi acak, ditampilkan sekali saat seeding |
| `SHADCN_BRAND_SUBTITLE` | — | teks kecil di bawah nama merek (sidebar) |
| `SHADCN_TERMS_URL` / `SHADCN_PRIVACY_URL` | — | tautan persetujuan di bawah kartu login |
| `SHADCN_*` lainnya | lihat `config/filament-shadcn.php` | gaya, warna, sidebar, login, showcase |

Seeder aman dijalankan ulang (`php artisan db:seed --class=AdminSeeder`): akun dicari berdasarkan email, dan kata sandi hanya ditimpa bila `ADMIN_PASSWORD` diisi.

## Hak akses

- `App\Models\User::canAccessPanel()` → hanya `is_admin`. Di production Filament **wajib** punya metode ini.
- `is_admin` tidak *fillable*; isi lewat `forceFill()` atau seeder.
- Halaman Tampilan: `->canCustomizeAppearance(fn () => auth()->user()?->is_admin)` di `AdminPanelProvider`.

Ubah aturan ini sesuai kebutuhan proyek (mis. pakai role/permission).

## Tes

```bash
composer test
```

Tes mencakup akses panel (tamu, admin, non-admin), halaman Tampilan, proteksi `is_admin`, dan `AdminSeeder`.

## Memperbarui tema

```bash
composer update mehuli/filament-shadcn
npm run build
```
