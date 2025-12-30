<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

use App\Models\Blog;
use App\Models\Service;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml for the website';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Ana sayfalar
        $sitemap->add(
            Url::create('/')
                ->setPriority(1.0)
                ->setChangeFrequency('daily')
        );

        $sitemap->add('/hakkimizda');
        $sitemap->add('/iletisim');
        $sitemap->add('/menu');

        // Bloglar
        if (class_exists(Blog::class)) {
            Blog::where('is_published', true)->get()->each(function ($blog) use ($sitemap) {
                $sitemap->add(
                    Url::create("/blog/{$blog->slug}")
                        ->setPriority(0.8)
                        ->setChangeFrequency('weekly')
                );
            });
        }

        // Hizmetler
        if (class_exists(Service::class)) {
            Service::where('is_published', true)->get()->each(function ($service) use ($sitemap) {
                $sitemap->add(
                    Url::create("/hizmetler/{$service->slug}")
                        ->setPriority(0.7)
                        ->setChangeFrequency('monthly')
                );
            });
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap başarıyla oluşturuldu.');
    }
}
