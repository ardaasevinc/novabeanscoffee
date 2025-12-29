<p>Sayın <strong>{{ $reservation->fname }} {{ $reservation->lname }}</strong>,</p>

<p>NovaKitchen'a gösterdiğiniz ilgi için teşekkür ederiz.</p>

<p>Üzülerek belirtmek isteriz ki, talep ettiğiniz tarih ve saatteki <strong>yoğunluk nedeniyle</strong> rezervasyon talebinize olumlu yanıt veremiyoruz.</p>

<p>
    <strong>Talep Detayları:</strong><br>
    Tarih: {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d.m.Y') }}<br>
    Saat: {{ $reservation->reservation_time }}
</p>

<p>Sizi başka bir zaman ağırlamaktan mutluluk duyarız. Farklı bir tarih veya saat için tekrar iletişime geçebilirsiniz.</p>

<p>Anlayışınız için teşekkür ederiz.</p>
<p>Saygılarımızla,<br>NovaKitchen Ekibi</p>