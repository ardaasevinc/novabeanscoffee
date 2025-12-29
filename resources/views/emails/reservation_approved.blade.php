<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervasyonunuz Onaylandı</title>
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
        
        .status-badge { 
            background-color: #d4edda; 
            color: #155724; 
            padding: 8px 15px; 
            border-radius: 20px; 
            font-size: 14px; 
            font-weight: bold; 
            display: inline-block; 
            margin-bottom: 20px;
        }

        .main-title { color: #121D23; font-size: 26px; font-weight: bold; margin-bottom: 10px; }
        
        /* Rezervasyon Özet Kutusu */
        .details-box { 
            background-color: #fafafa; 
            border-radius: 12px; 
            padding: 20px; 
            margin: 25px 0; 
            text-align: left;
            border: 1px solid #eee;
        }
        
        .detail-item { margin-bottom: 10px; font-size: 15px; }
        .detail-item strong { color: #121D23; }

        .button { 
            background-color: #121D23; 
            color: #ffffff !important; 
            padding: 15px 35px; 
            text-decoration: none; 
            border-radius: 8px; 
            font-weight: bold; 
            display: inline-block;
            margin-top: 10px;
        }

        .footer { padding: 30px; text-align: center; font-size: 13px; color: #888; background-color: #fafafa; }
    </style>
</head>
<body>
    <center class="wrapper">
        <table class="main">
            <tr>
                <td class="header">
                    <img src="https://novakitchen.com.tr/assets/images/logo.svg" alt="Nova Kitchen" width="160">
                </td>
            </tr>

            <tr>
                <td class="content">
                    <div class="status-badge">RESERVASYON ONAYLANDI</div>
                    <div class="main-title">Müjde! Masanız Hazırlanıyor.</div>
                    
                    <p>Sayın <strong>{{ $reservation->fname }} {{ $reservation->lname }}</strong>,</p>
                    <p>Rezervasyon talebiniz başarıyla onaylanmıştır. Sizi Nova Kitchen atmosferinde ağırlamak için sabırsızlanıyoruz.</p>

                    <div class="details-box">
                        <div class="detail-item"><strong>Tarih:</strong> {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d.m.Y') }}</div>
                        <div class="detail-item"><strong>Saat:</strong> {{ $reservation->reservation_time }}</div>
                        <div class="detail-item"><strong>Kişi Sayısı:</strong> {{ $reservation->guest_count }} Kişi</div>
                    </div>

                    <p>Masanız sizin için rezerve edilmiştir. Rezervasyon saatinizde sizi bekliyor olacağız.</p>

                    <div style="margin-top: 25px;">
                        <a href="https://maps.google.com/?q=Nova+Kitchen+Çatalca" class="button">Yol Tarifi Al</a>
                    </div>
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