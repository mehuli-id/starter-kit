<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Header keamanan HTTP (middleware SecurityHeaders)
    |--------------------------------------------------------------------------
    |
    | Dipasang di setiap respons. Content-Security-Policy tidak diaktifkan secara
    | bawaan karena Filament/Livewire memakai skrip & gaya inline; isi CSP_HEADER
    | bila sudah diuji untuk aplikasi Anda.
    |
    */

    'headers' => [
        'X-Frame-Options' => env('SECURITY_FRAME_OPTIONS', 'SAMEORIGIN'),
        'X-Content-Type-Options' => 'nosniff',
        'Referrer-Policy' => env('SECURITY_REFERRER_POLICY', 'strict-origin-when-cross-origin'),
        'Permissions-Policy' => env('SECURITY_PERMISSIONS_POLICY', 'camera=(), microphone=(), geolocation=(), payment=()'),
        'Content-Security-Policy' => env('CSP_HEADER'),
    ],

    // HSTS hanya dikirim lewat HTTPS. 0 = nonaktif.
    'hsts_max_age' => (int) env('SECURITY_HSTS_MAX_AGE', 31536000),

    /*
    |--------------------------------------------------------------------------
    | Kata sandi (Password::defaults(), dipakai form profil, daftar, reset sandi)
    |--------------------------------------------------------------------------
    |
    | uncompromised: cek ke layanan Have I Been Pwned (k-anonymity, butuh internet).
    |
    */

    'password' => [
        'min' => (int) env('PASSWORD_MIN_LENGTH', 12),
        'letters' => true,
        'numbers' => true,
        'uncompromised' => (bool) env('PASSWORD_UNCOMPROMISED', false),
    ],

];
