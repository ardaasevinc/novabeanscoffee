<?php

namespace App\Http\Controllers\Site\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog; // Modeli eklemeyi unutma
use Illuminate\Http\Request;
use App\Models\BlogCategory;

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

    public function categoryIndex($slug)
{
    // 1. Önce kategoriyi buluyoruz
    $category = BlogCategory::where('slug', $slug)->where('is_published', true)->firstOrFail();

    // 2. Bu kategoriye ait olan blogları çekiyoruz
    $blogs = Blog::where('blog_category_id', $category->id)
                 ->where('is_published', true)
                 ->orderBy('created_at', 'desc')
                 ->paginate(10);

                 $page_title = $category->title;

    return view('site.blog.index', compact('category', 'blogs','page_title'));
}
}