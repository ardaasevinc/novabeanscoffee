<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Canlıya çıkıştan önce en kritik yolların açıldığını gösteren hızlı testler (K-0048).
 */
class SmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_ana_sayfa_acilir(): void
    {
        $this->followingRedirects()->get('/')->assertOk();
    }

    public function test_yonetim_paneli_giris_sayfasi_acilir(): void
    {
        $this->get('/314agency/login')->assertOk();
    }

    public function test_giris_yapmamis_kullanici_panelden_girise_yonlendirilir(): void
    {
        $this->get('/314agency')->assertRedirect('/314agency/login');
    }
}
