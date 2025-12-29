<p>Sayın {{ $reservation->fname }} {{ $reservation->lname }},</p>
<p>Rezervasyon talebiniz tarafımıza ulaşmıştır. Ekibimiz müsaitlik durumunu kontrol etmektedir.</p>
<p>
    <strong>Tarih:</strong> {{ $reservation->reservation_date }}<br>
    <strong>Saat:</strong> {{ $reservation->reservation_time }}
</p>
<p>Onaylandığında size bilgilendirme maili gönderilecek ve ekibimiz tarafından teyit için aranacaksınız.</p>
<p>Teşekkürler,<br>NovaKitchen Ailesi</p>