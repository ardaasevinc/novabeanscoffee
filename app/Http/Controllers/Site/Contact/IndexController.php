<?php

namespace App\Http\Controllers\Site\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
// Mail sınıflarını eklemeyi unutma
use App\Mail\ContactFormReceived;
use App\Mail\NewContactMessageNotification;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function index()
    {
        $page_title = 'Bize Ulaşın';
        return view('site.contact.index', compact('page_title'));
    }

    // Formu Kaydetme Metodu
    public function contactStore(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'required|string',
        ]);

        // 1. Veritabanına Kayıt
        $contactMessage = ContactMessage::create($request->all());

        // 2. Mail Gönderimi (Hata olursa kullanıcıya yansıtma)
        try {
            // A) Kullanıcıya "Mesajınız alındı" maili gönder
            Mail::to($request->email)->send(new ContactFormReceived($contactMessage));

            // B) Yöneticiye "Yeni mesaj var" maili gönder
            // Buraya bildirim gitmesini istediğin yönetici mailini yaz
            $adminEmail = 'info@selquor.com'; // Veya env('MAIL_FROM_ADDRESS')
            Mail::to($adminEmail)->send(new NewContactMessageNotification($contactMessage));

        } catch (\Exception $e) {
            // Log::error('İletişim mail hatası: ' . $e->getMessage());
            // Mail gitmese bile kullanıcıya başarılı mesajı dönüyoruz.
        }

        return back()->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.');
    }
}