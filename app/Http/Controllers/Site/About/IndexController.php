<?php

namespace App\Http\Controllers\Site\About;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Faq; // Faq modelini ekledik
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $page_title = 'Hakkımızda';
        
        // Hakkımızda yazısı
        $about = About::where('is_published', true)->first();

        // Sıkça Sorulan Sorular (Sıraya göre çekiyoruz)
        $faqs = Faq::where('is_published', true)
                   ->orderBy('sort', 'asc')
                   ->get();

        return view('site.about.index', compact('page_title', 'about', 'faqs'));
    }
}