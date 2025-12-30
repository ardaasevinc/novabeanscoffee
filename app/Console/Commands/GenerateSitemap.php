<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Menu;
use App\Models\Blog;
use App\Models\About;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Nova Beans dinamik sitemap oluşturur';

    public function handle()
{
    // Sitemap nesnesini oluştur
    $sitemap = \Spatie\Sitemap\Sitemap::create();

    // 1. STATİK SAYFALAR (Bunlar kesinlikle görünmeli)
    $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency('daily'));
    $sitemap->add(Url::create('/bize-ulasin')->setPriority(0.7)->setChangeFrequency('monthly'));

    // 2. MENÜ ÖĞELERİ (Sorguyu kontrol ediyoruz)
    $menus = Menu::where('is_published', true)->get();
    foreach ($menus as $menu) {
        $sitemap->add(
            Url::create("/menu/{$menu->slug}")
                ->setLastModificationDate($menu->updated_at)
                ->setPriority(0.9)
        );
    }

    // 3. BLOG YAZILARI
    $blogs = Blog::where('is_published', true)->get();
    foreach ($blogs as $blog) {
        $sitemap->add(
            Url::create("/blog/{$blog->slug}")
                ->setLastModificationDate($blog->updated_at)
                ->setPriority(0.8)
        );
    }

    // 4. HAKKIMIZDA
    $abouts = About::where('is_published', true)->get();
    foreach ($abouts as $about) {
        $slug = $about->slug ?: 'hakkimizda';
        $sitemap->add(Url::create("/{$slug}")->setPriority(0.6));
    }

    // Dosyayı kaydet
    $sitemap->writeToFile(public_path('sitemap.xml'));

    // Terminale bilgi ver (Kaç kayıt eklendiğini gör)
    $this->info("Sitemap oluşturuldu! Toplam Menü: {$menus->count()}, Toplam Blog: {$blogs->count()}");
}
}