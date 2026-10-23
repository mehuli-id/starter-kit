<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Aturan kata sandi untuk form profil, daftar, dan reset sandi (config/security.php).
        Password::defaults(function (): Password {
            $config = config('security.password');
            $rule = Password::min((int) ($config['min'] ?? 12));

            if ($config['letters'] ?? true) {
                $rule->letters();
            }

            if ($config['numbers'] ?? true) {
                $rule->numbers();
            }

            if ($config['uncompromised'] ?? false) {
                $rule->uncompromised();
            }

            return $rule;
        });
    }
}
