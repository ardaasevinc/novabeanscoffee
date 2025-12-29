<h3>Yeni Bir İletişim Mesajı Alındı</h3>

<p>Web sitesinden yeni bir iletişim formu dolduruldu. Detaylar aşağıdadır:</p>

<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">
    <tr>
        <td style="background-color: #f3f3f3; font-weight: bold;">Ad Soyad:</td>
        <td>{{ $messageData->fname }} {{ $messageData->lname }}</td>
    </tr>
    <tr>
        <td style="background-color: #f3f3f3; font-weight: bold;">E-Posta:</td>
        <td>{{ $messageData->email }}</td>
    </tr>
    <tr>
        <td style="background-color: #f3f3f3; font-weight: bold;">Telefon:</td>
        <td>{{ $messageData->phone }}</td>
    </tr>
    <tr>
        <td style="background-color: #f3f3f3; font-weight: bold;">Mesaj:</td>
        <td>{{ $messageData->message }}</td>
    </tr>
</table>