<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ThreatProtection
{
    private const BAN_TTL          = 86400;   // 24 saat ban süresi (saniye)
    private const SCAN_WINDOW      = 60;      // tarama tespiti penceresi (saniye)
    private const SCAN_LIMIT       = 15;      // bu kadar 404/403 → ban
    private const LOGIN_WINDOW     = 300;     // brute force penceresi (saniye)
    private const LOGIN_LIMIT      = 10;      // bu kadar login denemesi → ban
    private const WHITELIST        = [        // asla banlanmaz
        '127.0.0.1',
        '::1',
        '128.140.43.196',                     // serdar sunucusu
        '78.182.128.133',                     // serdar (yönetici)
    ];

    // Gerçek shell/exploit tarama patternları
    private const SCAN_PATTERNS = [
        '/phpinfo', '/wp-admin', '/wp-login', '/.env',
        '/shell', '/cmd', '/eval', '/base64',
        '/phpmyadmin', '/pma', '/adminer',
        '/config.php', '/setup.php', '/install.php',
        '/xmlrpc', '/cgi-bin', '/etc/passwd',
        '/.git/', '/vendor/phpunit',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        if ($this->isWhitelisted($ip)) {
            return $next($request);
        }

        if ($this->isBanned($ip)) {
            return $this->blocked($ip, 'banned');
        }

        if ($this->isScanning($request, $ip)) {
            $this->ban($ip, 'scanner');
            return $this->blocked($ip, 'scanner');
        }

        $response = $next($request);

        $this->trackResponse($request, $ip, $response->getStatusCode());

        return $response;
    }

    private function isBanned(string $ip): bool
    {
        return Cache::has("threat:ban:{$ip}");
    }

    private function isWhitelisted(string $ip): bool
    {
        return in_array($ip, self::WHITELIST, true);
    }

    private function isScanning(Request $request, string $ip): bool
    {
        $path = strtolower($request->path());

        foreach (self::SCAN_PATTERNS as $pattern) {
            if (str_contains($path, ltrim($pattern, '/'))) {
                Log::channel('single')->warning('ThreatProtection: scan pattern', [
                    'ip'   => $ip,
                    'path' => $request->path(),
                    'ua'   => $request->userAgent(),
                ]);
                return true;
            }
        }

        return false;
    }

    private function trackResponse(Request $request, string $ip, int $status): void
    {
        // 404 sayacı — tarama tespiti (403 sayılmaz: korumalı sayfalar admin'i de banlardı)
        if ($status === 404) {
            $key   = "threat:scan:{$ip}";
            $count = Cache::increment($key);

            if ($count === 1) {
                Cache::expire($key, self::SCAN_WINDOW);
            }

            if ($count >= self::SCAN_LIMIT) {
                $this->ban($ip, "scan_limit:{$count}x404/403");
            }
        }

        // Login brute force — sadece login path'ında
        if ($status === 422 && str_contains($request->path(), 'login')) {
            $key   = "threat:login:{$ip}";
            $count = Cache::increment($key);

            if ($count === 1) {
                Cache::expire($key, self::LOGIN_WINDOW);
            }

            if ($count >= self::LOGIN_LIMIT) {
                $this->ban($ip, "brute_force:{$count}x_login");
            }
        }
    }

    private function ban(string $ip, string $reason): void
    {
        Cache::put("threat:ban:{$ip}", [
            'reason'    => $reason,
            'banned_at' => now()->toIso8601String(),
            'expires_at'=> now()->addSeconds(self::BAN_TTL)->toIso8601String(),
        ], self::BAN_TTL);

        Log::channel('single')->error('ThreatProtection: IP BANNED', [
            'ip'     => $ip,
            'reason' => $reason,
        ]);
    }

    private function blocked(string $ip, string $reason): Response
    {
        abort(403, 'Access denied.');
    }
}
