<h3>Yeni Rezervasyon Talebi</h3>
<p>Web sitesinden yeni bir masa rezervasyonu yapıldı. Detaylar aşağıdadır:</p>

<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;">
    <tr>
        <td style="background-color: #f3f3f3; font-weight: bold; width: 150px;">Müşteri:</td>
        <td>{{ $reservation->fname }} {{ $reservation->lname }}</td>
    </tr>
    <tr>
        <td style="background-color: #f3f3f3; font-weight: bold;">Tarih:</td>
        <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d.m.Y') }}</td>
    </tr>
    <tr>
        <td style="background-color: #f3f3f3; font-weight: bold;">Saat:</td>
        <td>{{ $reservation->reservation_time }}</td>
    </tr>
    <tr>
        <td style="background-color: #f3f3f3; font-weight: bold;">Telefon:</td>
        <td>{{ $reservation->phone }}</td>
    </tr>
    <tr>
        <td style="background-color: #f3f3f3; font-weight: bold;">E-Posta:</td>
        <td>{{ $reservation->email }}</td>
    </tr>
</table>

<p>
    <a href="{{ url('/admin/reservations') }}" style="background-color: #000; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Yönetim Paneline Git ve Onayla
    </a>
</p>