<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Kitchen Bildirim</title>
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
            border-radius: 15px; /* Kenar ovali */
            overflow: hidden; /* Köşelerin taşmasını engeller */
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
        }

        /* Header - Arka Plan #121D23 */
        .header { background-color: #121D23; padding: 40px; text-align: center; }
        
        .content { padding: 40px 30px; line-height: 1.6; }
        
        /* Bilgi Tablosu */
        .table-info { width: 100%; border-collapse: collapse; margin: 20px 0; background-color: #fafafa; border-radius: 10px; }
        .table-info td { padding: 15px; border-bottom: 1px solid #eeeeee; }
        .label { font-weight: bold; color: #121D23; width: 35%; }

        /* Buton */
        .button { 
            background-color: #121D23; 
            color: #ffffff !important; 
            padding: 15px 30px; 
            text-decoration: none; 
            border-radius: 8px; 
            font-weight: bold; 
            display: inline-block;
            margin-top: 20px;
        }

        .footer { padding: 30px; text-align: center; font-size: 13px; color: #888; }
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
                    <h2 style="color: #121D23; margin-top: 0; text-align: center;">Yeni Rezervasyon Talebi</h2>
                    <p style="text-align: center;">Web siteniz üzerinden yeni bir randevu oluşturuldu.</p>

                    <table class="table-info">
                        <tr>
                            <td class="label">Müşteri:</td>
                            <td>{{ $reservation->fname }} {{ $reservation->lname }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tarih:</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d.m.Y') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Saat:</td>
                            <td>{{ $reservation->reservation_time }}</td>
                        </tr>
                        <tr>
                            <td class="label">Telefon:</td>
                            <td>{{ $reservation->phone }}</td>
                        </tr>
                        <tr>
                            <td class="label">E-Posta:</td>
                            <td>{{ $reservation->email }}</td>
                        </tr>
                    </table>

                    <div style="text-align: center;">
                        <a href="https://novakitchen.com.tr/ardaasevinc" class="button">
                            Yönetim Paneline Git
                        </a>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="footer">
                    <strong>Nova Kitchen Restaurant</strong><br>
                    Bu e-posta otomatik olarak gönderilmiştir. <br>
                    © {{ date('Y') }} Tüm Hakları Saklıdır.
                </td>
            </tr>
        </table>
    </center>
</body>
</html>