<?php

namespace App\Http\Controllers\Site\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuCategory;

class IndexController extends Controller
{
    public function index()
    {
        $page_title = 'Menü';

        $menuCategories = MenuCategory::query()
            ->where('is_published', true)
            // Kategorileri Filament'te belirlediğimiz sıraya göre çekiyoruz
            ->orderBy('sort_order', 'asc')
            ->with([
                'menus' => function ($q) {
                    $q->where('is_published', true);
                    // Eğer ürünlerde de (Menu modeli) sıralama varsa buraya ekleyebilirsin:
                    // $q->orderBy('sort_order', 'asc');
                }
            ])
            ->get();

        return view('site.menu.index', compact('page_title', 'menuCategories'));
    }
}