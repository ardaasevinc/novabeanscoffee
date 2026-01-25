<?php

namespace App\Http\Controllers\Site\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Mail\ContactFormReceived;
use App\Mail\NewContactMessageNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;

class IndexController extends Controller
{
    public function index()
    {
        $page_title = 'Bize Ulaşın';
        return view('site.contact.index', compact('page_title'));
    }

    /**
     * Form Gönderme - Kayıt + Mail + Turnstile Doğrulama
     */
    public function contactStore(Request $request)
    {
        /* ==========================================================
         * 0) FORM VALİDATİON
         * ========================================================== */
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'required|string',
        ]);

        /* ==========================================================
         * 1) CLOUDFLARE TURNSTILE DOĞRULAMASI
         * ========================================================== */
        $verify = Http::asForm()->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'secret' => env('CF_TURNSTILE_SECRET_KEY'),
                'response' => $request->input('cf-turnstile-response'),
                'remoteip' => $request->ip(),
            ]
        )->json();

        if (!($verify['success'] ?? false)) {
            return back()->with('error', 'Lütfen doğrulamayı tamamlayın.');
        }

        /* ==========================================================
         * 2) DB KAYIT
         * ========================================================== */
        $contactMessage = ContactMessage::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);

        /* ==========================================================
         * 3) MAİL GÖNDERİMİ
         * ========================================================== */
        try {
            // Kullanıcıya otomatik mail
            Mail::to($request->email)->send(
                new ContactFormReceived($contactMessage)
            );

            // Yöneticiye bilgilendirme maili
            $adminEmail = Setting::first()?->email ?? 'info@selquor.com';

            Mail::to($adminEmail)->send(
                new NewContactMessageNotification($contactMessage)
            );

        } catch (\Exception $e) {
            // Mail hataları loglanabilir, kullanıcıya yansıtılmıyor.
            // Log::error($e->getMessage());
        }

        /* ==========================================================
         * 4) BAŞARILI GERİ DÖNÜŞ
         * ========================================================== */
        return back()->with(
            'success',
            'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.'
        );
    }
}
