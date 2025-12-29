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

        $menuCategories = MenuCategory::where('is_published', true)
        ->with(['menus' => function($q) {
            $q->where('is_published', true);
        }])
        ->get();
       
        return view('site.menu.index', compact('page_title','menuCategories'));
    }
}
