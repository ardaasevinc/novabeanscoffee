<?php

namespace App\Http\Controllers\Site\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog; // Modeli eklemeyi unutma
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $page_title = 'Blog';

        // Yayınlanmış blogları çek, sayfada 9 tane göster
        $blogs = Blog::where('is_published', true)
                     ->latest()
                     ->paginate(9);

        // 'site.blog.index' view dosyanın tam yoludur (resources/views/site/blog/index.blade.php)
        return view('site.blog.index', compact('page_title', 'blogs'));
    }

    public function detail($slug)
    {
        // Slug'a göre yayınlanmış blogu bul, bulamazsa 404 hatası ver
        $blog = Blog::where('slug', $slug)
                    ->where('is_published', true)
                    ->firstOrFail();

        // Sayfa başlığı blog başlığı olsun
        $page_title = $blog->title;

        return view('site.blog.detail', compact('page_title', 'blog'));
    }
}