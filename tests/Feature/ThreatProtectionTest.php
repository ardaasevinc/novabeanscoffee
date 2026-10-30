<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * ThreatProtection Cloudflare arkasında (K-0107): ban gerçek ziyaretçi IP'sine uygulanır; Cloudflare kenar IP'si ve
 * izleme sunucusu asla banlanmaz. İstekler gerçek HTTP çekirdeğinden geçer (ara katman sırası da sınanır).
 */
class ThreatProtectionTest extends TestCase
{
    private const CLOUDFLARE = '173.245.48.10';

    protected function setUp(): void
    {
        parent::setUp();

        config(['cache.default' => 'array']);
        Cache::flush();
        Route::get('/_tp-testi', fn () => 'tamam');
    }

    /** Cloudflare kenarından, X-Forwarded-For'da verilen ziyaretçi adına istek. */
    private function cloudflaredan(string $yol, ?string $ziyaretci = null)
    {
        $sunucu = ['REMOTE_ADDR' => self::CLOUDFLARE] + ($ziyaretci ? ['HTTP_X_FORWARDED_FOR' => $ziyaretci] : []);

        return $this->call('GET', $yol, [], [], [], $sunucu);
    }

    public function test_cloudflare_ipsinden_gelen_tarama_kenar_ipsini_banlamaz(): void
    {
        $this->cloudflaredan('/wp-login.php');

        $this->assertFalse(Cache::has('threat:ban:'.self::CLOUDFLARE));
        $this->cloudflaredan('/_tp-testi')->assertOk();
    }

    public function test_gercek_ipden_tarama_yalnizca_o_ipyi_banlar(): void
    {
        $this->cloudflaredan('/wp-login.php', '198.51.100.7')
            ->assertForbidden()
            ->assertHeader('X-Engel', 'threat-ban');

        $this->assertTrue(Cache::has('threat:ban:198.51.100.7'));
        $this->assertFalse(Cache::has('threat:ban:'.self::CLOUDFLARE));

        // Aynı Cloudflare kenarından gelen başka ziyaretçi etkilenmez; banlanan ziyaretçi engellenir.
        $this->cloudflaredan('/_tp-testi', '198.51.100.8')->assertOk();
        $this->cloudflaredan('/_tp-testi', '198.51.100.7')->assertForbidden()->assertHeader('X-Engel', 'threat-ban');
    }

    public function test_izleme_sunucusu_hic_banlanmaz(): void
    {
        $this->assertNotSame(403, $this->cloudflaredan('/wp-login.php', '2.31.43.210')->status());
        $this->assertFalse(Cache::has('threat:ban:2.31.43.210'));
        $this->cloudflaredan('/_tp-testi', '2.31.43.210')->assertOk();
    }

    public function test_eski_beyaz_liste_adresleri_artik_korunmaz(): void
    {
        $this->cloudflaredan('/wp-login.php', '128.140.43.196')->assertForbidden();
        $this->assertTrue(Cache::has('threat:ban:128.140.43.196'));
    }

    public function test_origine_dogrudan_gelen_sahte_x_forwarded_for_yok_sayilir(): void
    {
        // Origin'e doğrudan gelen (Cloudflare olmayan) biri başlıkla başka IP'yi banlatamaz; ban kendi IP'sine uygulanır.
        $this->call('GET', '/wp-login.php', [], [], [], ['REMOTE_ADDR' => '203.0.113.5', 'HTTP_X_FORWARDED_FOR' => '198.51.100.9'])
            ->assertForbidden();

        $this->assertTrue(Cache::has('threat:ban:203.0.113.5'));
        $this->assertFalse(Cache::has('threat:ban:198.51.100.9'));
    }
}
