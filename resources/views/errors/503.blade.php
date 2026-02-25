<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Çok Yakında</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0eee9; /* Hafif gri arka plan */
        }
        .bg-container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        h1 {
            font-weight: 700;
            font-size: 3.5rem;
            color: #212529;
            letter-spacing: -1px;
            animation: fadeIn 2s ease-in-out;
        }
        /* Basit bir giriş animasyonu */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="bg-container">
        <div class="container">
            <h1 class="display-1">Çok Yakında</h1>
            <p class="lead text-secondary">Sizler için harika bir şey hazırlıyoruz.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>