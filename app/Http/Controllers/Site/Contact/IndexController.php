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
use Illuminate\Support\Facades\Log; // Log eklemeyi unutma

class IndexController extends Controller
{
    public function index()
    {
        // View içerisinde $setting zaten bir ViewShare veya Global veri değilse 
        // burada çekip göndermek gerekebilir.
        $setting = Setting::first();
        $page_title = 'Bize Ulaşın';
        return view('site.contact.index', compact('page_title', 'setting'));
    }

    public function contactStore(Request $request)
    {
        // 1) VALIDATION (Turnstile dahil)
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:2000',
            'cf-turnstile-response' => 'required' // Formdan gelen token
        ]);

        // 2) TURNSTILE DOĞRULAMA (HTTP Client)
        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => config('services.turnstile.secret'), // config üzerinden güvenli erişim
            'response' => $request->input('cf-turnstile-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json('success')) {
            return back()->withErrors(['captcha' => 'Güvenlik doğrulaması başarısız oldu.'])->withInput();
        }

        // 3) DB KAYIT (Sadece validated veriyi almak daha güvenlidir)
        $contactMessage = ContactMessage::create($request->only(['fname', 'lname', 'email', 'phone', 'message']));

        // 4) MAİL GÖNDERİMİ
        try {
            $adminEmail = Setting::first()?->email ?? config('mail.from.address');

            // Mail gönderimlerini hızlandırmak için (eğer Queue ayarlıysa) ->queue() kullanabilirsin
            Mail::to($request->email)->send(new ContactFormReceived($contactMessage));
            Mail::to($adminEmail)->send(new NewContactMessageNotification($contactMessage));

        } catch (\Exception $e) {
            Log::error('İletişim Formu Mail Hatası: ' . $e->getMessage());
        }

        return back()->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.');
    }
}