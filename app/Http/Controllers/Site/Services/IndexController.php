<?php

namespace App\Http\Controllers\Site\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service; // Service modelini dahil etmeyi unutma
use App\Models\Faq;

class IndexController extends Controller
{
    public function index()
    {
        $page_title = 'Hizmetler';
        
        // Sadece yayında olanları getir
        $services = Service::where('is_published', true)->latest()->get();
        
        return view('site.services.index', compact('page_title', 'services'));
    }

   public function detail($slug)
{
    // Mevcut görüntülenen hizmet
    $service = Service::where('slug', $slug)
                      ->where('is_published', true)
                      ->firstOrFail();

    // Sidebar'da listelemek için diğer tüm hizmetler
    $allServices = Service::where('is_published', true)->get();

    // Sayfa başlığı
    $page_title = $service->title;
      $faqs = Faq::where('is_published', true)
                   ->orderBy('sort', 'asc')
                   ->get();

    return view('site.services.detail', compact('page_title', 'service', 'allServices','faqs'));
}
}