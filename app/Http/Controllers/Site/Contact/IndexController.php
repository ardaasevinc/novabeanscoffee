<?php

namespace App\Http\Controllers\Site\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Mail\ContactFormReceived;
use App\Mail\NewContactMessageNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;

class IndexController extends Controller
{
    public function index()
    {
        $page_title = 'Bize Ulaşın';
        return view('site.contact.index', compact('page_title'));
    }

    public function contactStore(Request $request)
    {
        // FORM VALIDATION
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'required|string',
        ]);

        // SADECE MODELDEKİ ALANLARI AL
        $data = [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ];

        // DB KAYIT
        $contactMessage = ContactMessage::create($data);

        // MAİLLER
        try {
            Mail::to($request->email)
                ->send(new ContactFormReceived($contactMessage));

            $adminEmail = Setting::first()?->email ?? 'info@selquor.com';

            Mail::to($adminEmail)
                ->send(new NewContactMessageNotification($contactMessage));

        } catch (\Throwable $e) {
            // Mail hatalarını gösterme (sessizce geç)
            // dd($e->getMessage()); // DEBUG için açılabilir
        }

        return back()->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.');
    }
}
