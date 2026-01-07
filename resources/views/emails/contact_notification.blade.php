<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni İletişim Mesajı</title>
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
        
        .content { padding: 40px 30px; line-height: 1.6; }
        
        /* Bilgi Tablosu */
        .table-info { width: 100%; border-collapse: collapse; margin: 20px 0; background-color: #fafafa; border-radius: 10px; overflow: hidden; }
        .table-info td { padding: 15px; border-bottom: 1px solid #eeeeee; font-size: 14px; }
        .label { font-weight: bold; color: #121D23; width: 30%; background-color: #f3f3f3; }

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
                    <img src="https://novabeanscoffee.com/assets/images/logo.svg" alt="Nova Beans Coffee" width="160">
                </td>
            </tr>

            <tr>
                <td class="content">
                    <h2 style="color: #121D23; margin-top: 0; text-align: center;">Yeni Bir İletişim Mesajı Alındı</h2>
                    <p style="text-align: center;">Web sitesinden yeni bir iletişim formu dolduruldu. Detaylar aşağıdadır:</p>

                    <table class="table-info">
                        <tr>
                            <td class="label">Ad Soyad:</td>
                            <td>{{ $messageData->fname }} {{ $messageData->lname }}</td>
                        </tr>
                        <tr>
                            <td class="label">E-Posta:</td>
                            <td>{{ $messageData->email }}</td>
                        </tr>
                        <tr>
                            <td class="label">Telefon:</td>
                            <td>{{ $messageData->phone }}</td>
                        </tr>
                        <tr>
                            <td class="label">Mesaj:</td>
                            <td style="white-space: pre-wrap;">{{ $messageData->message }}</td>
                        </tr>
                    </table>

                    <div style="text-align: center;">
                        <a href="https://novabeanscofee.com/ardaasevinc" class="button">
                            Yönetim Paneline Git
                        </a>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="footer">
                    <strong>Nova Beans Coffee</strong><br>
                    Bu mesaj web sitesi iletişim formu aracılığıyla gönderilmiştir.<br>
                    © {{ date('Y') }} Tüm Hakları Saklıdır.
                </td>
            </tr>
        </table>
    </center>
</body>
</html>