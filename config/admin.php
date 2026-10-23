<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Panel admin
    |--------------------------------------------------------------------------
    |
    | Path URL panel Filament, mis. "admin" → https://domain/admin.
    |
    */

    'panel_path' => env('ADMIN_PANEL_PATH', 'admin'),

    /*
    |--------------------------------------------------------------------------
    | Akun admin awal (dibuat oleh AdminSeeder)
    |--------------------------------------------------------------------------
    |
    | Tanpa ADMIN_EMAIL, seeder dilewati. Tanpa ADMIN_PASSWORD, seeder membuat
    | kata sandi acak dan menampilkannya sekali di terminal. Kata sandi hanya dipakai
    | saat akun dibuat; kosongkan ADMIN_PASSWORD di .env setelah seeding pertama.
    |
    */

    'name' => env('ADMIN_NAME', 'Administrator'),

    'email' => env('ADMIN_EMAIL'),

    'password' => env('ADMIN_PASSWORD'),

    // true = timpa kata sandi akun admin yang sudah ada saat seeding (sekali pakai, lalu kembalikan ke false).
    'reset_password' => (bool) env('ADMIN_RESET_PASSWORD', false),

];
