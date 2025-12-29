<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervasyon Talebiniz Alındı</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f0f0f0; color: #333; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f0f0f0; padding: 40px 0; }
        
        /* Ana Çerçeve ve Radius */
        .main { 
            background-color: #ffffff; 
            margin: 0 auto; 
            width: 100%; 
            max-width: 600px; 
            border-spacing: 0; 
            border-radius: 15px; 
            overflow: hidden; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
        }

        /* Header - Marka Rengi #121D23 */
        .header { background-color: #121D23; padding: 40px; text-align: center; }
        
        .content { padding: 50px 40px; line-height: 1.8; text-align: center; }
        
        /* Durum Rozeti - Bekleme tonu (Sarı/Turuncu) */
        .status-badge { 
            background-color: #fff3cd; 
            color: #856404; 
            padding: 8px 15px; 
            border-radius: 20px; 
            font-size: 13px; 
            font-weight: bold; 
            display: inline-block; 
            margin-bottom: 20px;
        }

        .main-title { color: #121D23; font-size: 24px; font-weight: bold; margin-bottom: 15px; }
        
        /* Özet Kutusu */
        .details-box { 
            background-color: #fafafa; 
            border-radius: 12px; 
            padding: 20px; 
            margin: 25px 0; 
            text-align: left;
            border: 1px solid #eee;
        }
        
        .detail-item { margin-bottom: 8px; font-size: 15px; }
        .detail-item strong { color: #121D23; }

        .footer { padding: 30px; text-align: center; font-size: 13px; color: #888; background-color: #fafafa; }
    </style>
</head>
<body>
    <center class="wrapper">
        <table class="main">
            <tr>
                <td class="header">
                    <img src="https://novakitchen.com.tr/images/logo.svg" alt="Nova Kitchen" width="160">
                </td>
            </tr>

            <tr>
                <td class="content">
                    <div class="status-badge">TALEBİNİZ İNCELENİYOR</div>
                    <div class="main-title">Rezervasyon Talebiniz Bize Ulaştı</div>
                    
                    <p>Sayın <strong>{{ $reservation->fname }} {{ $reservation->lname }}</strong>,</p>
                    <p>Nova Kitchen'a yaptığınız rezervasyon talebi başarıyla tarafımıza ulaşmıştır. Ekibimiz şu anda müsaitlik durumunu kontrol etmektedir.</p>

                    <div class="details-box">
                        <div class="detail-item"><strong>Tarih:</strong> {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d.m.Y') }}</div>
                        <div class="detail-item"><strong>Saat:</strong> {{ $reservation->reservation_time }}</div>
                        @if(isset($reservation->guest_count))
                        <div class="detail-item"><strong>Kişi Sayısı:</strong> {{ $reservation->guest_count }} Kişi</div>
                        @endif
                    </div>

                    <p>Talebiniz onaylandığında size tekrar bir bilgilendirme maili gönderilecek ve ekibimiz tarafından teyit için telefonla aranacaksınız.</p>
                </td>
            </tr>

            <tr>
                <td class="footer">
                    <strong>Nova Kitchen Restaurant</strong><br>
                    Ferhatpaşa, Çatalca/İstanbul<br>
                    © {{ date('Y') }} Tüm Hakları Saklıdır.
                </td>
            </tr>
        </table>
    </center>
</body>
</html>