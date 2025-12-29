<?php

namespace App\Http\Controllers\Site\Reservation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Mail\ReservationReceived; // Müşteri Maili
use App\Mail\AdminNewReservationNotification; // Admin Bildirim Maili (BUNU EKLEDİK)
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    /**
     * Rezervasyon sayfasını (formu) gösterir.
     */
    public function index()
    {
        $page_title = 'Rezervasyon';
        return view('site.booktable.index', compact('page_title'));
    }

    /**
     * Formdan gelen veriyi kaydeder ve mail atar.
     */
    public function store(Request $request)
    {
        // 1. Validasyon
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'date'  => 'required|date|after_or_equal:today',
            'time'  => 'required',
        ], [
            'date.after_or_equal' => 'Lütfen bugünden ileri bir tarih seçiniz.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
        ]);

        // 2. Veritabanına Kayıt
        $reservation = Reservation::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'reservation_date' => $request->date,
            'reservation_time' => $request->time,
            'status' => 'pending', 
        ]);

        // 3. Mail Gönderimi
        try {
            // A) Müşteriye "Talebiniz alındı" maili
            Mail::to($request->email)->send(new ReservationReceived($reservation));
            
            // B) Admine (info@selquor.com) "Yeni rezervasyon var" maili
            Mail::to('info@selquor.com')->send(new AdminNewReservationNotification($reservation));
            
        } catch (\Exception $e) {
            // Mail hatası olursa loglayabilirsin
            // \Log::error('Rezervasyon mail hatası: ' . $e->getMessage());
        }

        // 4. Başarı Mesajı
        return back()->with('success', 'Rezervasyon talebiniz başarıyla alındı. Müsaitlik durumuna göre onaylandığında size SMS veya E-posta yoluyla dönüş yapılacaktır.');
    }
}