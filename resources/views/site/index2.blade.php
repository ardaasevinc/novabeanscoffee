<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

    <title>{{ $setting?->meta_title }}</title>
    
    @if($setting?->favicon)
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/' . $setting->favicon) }}">
    @endif

    <meta name="theme-color" content="#000">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Forum&family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" media="screen">

    <style>
        :root {
            --accent-color: #bc9c6c;
        }

        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
            font-family: 'Jost', sans-serif;
        }

        .splash-wrapper {
            display: flex;
            height: 100vh;
            width: 100%;
            background: c;
        }

        .splash-item {
            position: relative;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.6s ease-in-out;
            overflow: hidden;
        }

        /* Arka Plan Görselleri */
        .kitchen-bg {
            background: url('{{ asset("assets/images/kitchen-bg.jpg") }}') no-repeat center center;
            background-size: cover;
        }

        .coffee-bg {
            background: url('{{ asset("assets/images/novabeans-bg.jpg") }}') no-repeat center center;
            background-size: cover;
        }

        /* Karartma Katmanı */
        .splash-item::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(18, 29, 35, 0.6); 
            transition: background 0.5s ease;
            z-index: 1;
        }

        .splash-item:hover::before {
            background: rgba(18, 29, 35, 0.4); /* Üzerine gelince biraz aydınlanır */
        }

        /* İçeriklerin Katman Üstünde Kalması */
        .splash-item > * {
            position: relative;
            z-index: 2;
        }

        .logo-box {
            width: 220px;
            height: 220px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            transition: 0.5s;
            background: rgba(18, 29, 35, 0.3);
            backdrop-filter: blur(5px);
        }

        .splash-item:hover .logo-box {
            border-color: var(--accent-color);
            transform: scale(1.05);
        }

        .logo-box img {
            max-width: 100%;
            height: auto;
        }

        .splash-item h2 {
            font-family: 'Forum', serif;
            color: #fff;
            margin-top: 25px;
            font-size: 2.8rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
        }

        .enter-text {
            color: var(--accent-color);
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* Mobil */
        @media (max-width: 768px) {
            .splash-wrapper { flex-direction: column; }
            .logo-box { width: 150px; height: 150px; }
            .splash-item h2 { font-size: 1.8rem; }
        }
    </style>
</head>

<body>

    <div class="splash-wrapper">
        
        <a href="{{ url('https://novakitchen.com.tr/anasayfa') }}" class="splash-item kitchen-bg wow fadeInLeft" data-wow-delay="0.2s">
            <div class="logo-box">
                <img src="{{ asset('assets/images/logo-kitchen.svg') }}" alt="Nova Kitchen Logo">
            </div>
            <h2>Nova Kitchen</h2>
            <span class="enter-text">Restoranı Keşfet <i class="fa-solid fa-arrow-right-long"></i></span>
        </a>

        <a href="{{ route('site.index') }}" class="splash-item coffee-bg wow fadeInRight" data-wow-delay="0.4s">
            <div class="logo-box">
                <img src="{{ asset('assets/images/logo-coffee.svg') }}" alt="Nova Beans Coffee Logo">
            </div>
            <h2>Nova Beans</h2>
            <span class="enter-text">Kafeyi Keşfet <i class="fa-solid fa-arrow-right-long"></i></span>
        </a>

    </div>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    
    <script>
        new WOW().init();
    </script>

</body>
</html>