<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Yalnızca Cloudflare'in IP aralıklarından gelen X-Forwarded-For/Proto başlıklarına güvenilir; X-Forwarded-Host'a hiç
        // güvenilmez. Böylece $request->ip() Cloudflare kenar IP'si değil gerçek ziyaretçi olur (K-0107).
        $middleware->trustProxies(
            at: require __DIR__.'/cloudflare-ips.php',
            headers: \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR | \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO,
        );

        // ThreatProtection TrustProxies'ten SONRA çalışmalı (append): prepend ile en başa eklendiğinde vekil başlıkları
        // henüz işlenmemiş oluyor ve Cloudflare kenar IP'sini banlayıp oradan geçen bütün ziyaretçileri engelliyordu.
        $middleware->append(\App\Http\Middleware\ThreatProtection::class);
        $middleware->appendToGroup('web', \Spatie\Honeypot\ProtectAgainstSpam::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
