<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Header keamanan dasar untuk semua respons (lihat config/security.php):
 * anti-clickjacking, nosniff, referrer policy, permissions policy, HSTS (HTTPS),
 * dan tanpa X-Powered-By.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        foreach ((array) config('security.headers', []) as $name => $value) {
            if (filled($value) && ! $response->headers->has($name)) {
                $response->headers->set($name, (string) $value);
            }
        }

        $hsts = (int) config('security.hsts_max_age', 0);

        if ($hsts > 0 && $request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', "max-age={$hsts}; includeSubDomains");
        }

        $response->headers->remove('X-Powered-By');

        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
        }

        return $response;
    }
}
