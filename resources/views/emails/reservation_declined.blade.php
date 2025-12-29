<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervasyon Talebiniz Hakkında</title>
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

        /* Header - #121D23 */
        .header { background-color: #121D23; padding: 40px; text-align: center; }
        
        .content { padding: 50px 40px; line-height: 1.8; text-align: center; }
        
        /* Durum Rozeti - Daha nötr bir gri/mavi tonu */
        .status-badge { 
            background-color: #e9ecef; 
            color: #495057; 
            padding: 8px 15px; 
            border-radius: 20px; 
            font-size: 13px; 
            font-weight: bold; 
            display: inline-block; 
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        .main-title { color: #121D23; font-size: 24px; font-weight: bold; margin-bottom: 15px; }
        
        /* Detay Kutusu */
        .details-box { 
            background-color: #fff9f9; /* Çok hafif kırmızımsı beyaz, uyarı tonu */
            border-radius: 12px; 
            padding: 20px; 
            margin: 25px 0; 
            text-align: left;
            border: 1px solid #f5e7e7;
        }
        
        .detail-item { margin-bottom: 8px; font-size: 15px; }
        .detail-item strong { color: #121D23; }

        .button { 
            background-color: #121D23; 
            color: #ffffff !important; 
            padding: 15px 30px; 
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
                    <img src="https://novakitchen.com.tr/images/logo.svg" alt="Nova Kitchen" width="160">
                </td>
            </tr>

            <tr>
                <td class="content">
                    <div class="status-badge">REZERVASYON TALEBİ HAKKINDA</div>
                    <div class="main-title">Küçük Bir Bilgilendirme</div>
                    
                    <p>Sayın <strong>{{ $reservation->fname }} {{ $reservation->lname }}</strong>,</p>
                    <p>Nova Kitchen'a gösterdiğiniz ilgi için teşekkür ederiz. Rezervasyon talebinizi büyük bir memnuniyetle aldık ancak bir durum paylaşmamız gerekiyor.</p>

                    <p>Üzülerek belirtmek isteriz ki, talep ettiğiniz tarih ve saatteki <strong>yoğunluk nedeniyle</strong> şu an için talebinize olumlu yanıt veremiyoruz.</p>

                    <div class="details-box">
                        <div style="font-weight: bold; margin-bottom: 10px; color: #b02a37;">Talep Edilen Bilgiler:</div>
                        <div class="detail-item"><strong>Tarih:</strong> {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d.m.Y') }}</div>
                        <div class="detail-item"><strong>Saat:</strong> {{ $reservation->reservation_time }}</div>
                    </div>

                    <p>Sizi farklı bir tarihte veya saatte ağırlamayı çok isteriz. Yeni bir talep oluşturmak için web sitemizi tekrar ziyaret edebilirsiniz.</p>

                    <div style="margin-top: 25px;">
                        <a href="https://novakitchen.com.tr" class="button">Farklı Bir Tarih Seç</a>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="footer">
                    <strong>Nova Kitchen Restaurant</strong><br>
                    Anlayışınız için teşekkür ederiz.<br>
                    © {{ date('Y') }} Tüm Hakları Saklıdır.
                </td>
            </tr>
        </table>
    </center>
</body>
</html>