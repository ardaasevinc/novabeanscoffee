<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hero;
use App\Models\About;
use App\Models\WhyChoose;
use App\Models\MenuCategory;
use App\Models\BlogCategory;
use App\Models\Offer;
use App\Models\Menu;


class IndexController extends Controller
{
    public function index()
    {
        $page_title = 'Ana Sayfa';
        $heroes = Hero::where('is_published', true)->get();
        $about = About::where('is_published', true)->first();
        $whyChoose = WhyChoose::where('is_published', true)->first();
        $menuCategories = MenuCategory::where('is_published', true)->get();

        foreach ($menuCategories as $category) {
            // Model'e eklediğimiz menus() ilişkisini burada kullanıyoruz
            $category->setRelation(
                'home_menus',
                $category->menus()
                    ->where('is_published', true)
                    ->latest()
                    ->take(5) // Her kategoriden sadece son 5 ürün
                    ->get()
            );
        }

        $offers = Offer::where('is_published', true)
                   ->orderBy('sort', 'asc')
                   ->get();

        $blogCategories = BlogCategory::where('is_published', true)->take(4)->get();
        $tickerItems = Menu::where('is_published', true)->select('title')->get();
        return view('site.index', compact('page_title', 'heroes', 'about', 'whyChoose', 'menuCategories','blogCategories','offers','tickerItems'));
    }
}
