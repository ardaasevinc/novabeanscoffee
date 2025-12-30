<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesajınız Alındı</title>
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
        
        .thank-you { color: #121D23; font-size: 24px; font-weight: bold; margin-bottom: 20px; }

        /* Altın Sarısı Vurgu Rengi (Opsiyonel: Buton veya çizgi için) */
        .divider { height: 2px; width: 50px; background-color: #121D23; margin: 25px auto; }

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
                    <div class="thank-you">Mesajınız Bize Ulaştı!</div>
                    <div class="divider"></div>
                    
                    <p>Sayın <strong>{{ $messageData->fname }} {{ $messageData->lname }}</strong>,</p>

                    <p>İletişim formumuz aracılığıyla gönderdiğiniz mesaj tarafımıza başarıyla ulaşmıştır. Bizimle iletişime geçtiğiniz için teşekkür ederiz.</p>
                    
                    <p>Ekibimiz mesajınızı inceledikten sonra en kısa sürede belirttiğiniz iletişim kanalları üzerinden sizinle irtibata geçecektir.</p>

                    <div style="margin-top: 30px;">
                        <a href="https://novabeanscoffee.com" class="button">Web Sitemize Dön</a>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="footer">
                    <strong>Nova Beans Coffee</strong><br>
                    Çatalca, İstanbul<br>
                    © {{ date('Y') }} Tüm Hakları Saklıdır.
                </td>
            </tr>
        </table>
    </center>
</body>
</html>