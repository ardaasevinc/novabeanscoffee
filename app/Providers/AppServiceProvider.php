<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\View;


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
        // Paylaşılan veriler açılışta değil, bir view render edilince ve istek başına bir kez sorgulanır:
        // açılışta tablo yokken (ilk kurulum, testler) paylaşım atlanıp layout'ta "tanımsız değişken" hatası oluşmaz,
        // JSON/API istekleri ve artisan komutları da gereksiz sorgu atmaz.
        View::composer('*', function ($view) {
            $view->with('setting', once(fn () => Setting::where('is_published', true)->first()));
        });
    }
}
