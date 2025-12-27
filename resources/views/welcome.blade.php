<!doctype html>
<html lang="en">
    <head>
        <title>Nova Kitchen</title>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body style="background-color: #F0EEE9; overflow-x: hidden;"> <header>
            </header>
        
        <main>
            <div class="d-flex justify-content-center align-items-center vh-100" style="position: relative; z-index: 10;">
                <img style="max-height:200px;" src="{{ asset('assets/nova/logo.svg') }}" alt="Logo">
            </div>
        </main>
        
        <footer>
            <div class="container-fluid bg-white fixed-bottom" style="z-index: 10;">
                <div class="row">
                    <div class="col-12">
                        <p class="text-center text-gray-700 py-2 mb-0">
                            &copy; {{ now()->year }} Nova Kitchen."Kusursuz anlar için."
                        </p>
                    </div>
                </div>
            </div>
        </footer>

        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>

        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>
        <script>
            // Konfeti animasyonu
            var duration = 15 * 1000;
            var animationEnd = Date.now() + duration;
            var skew = 1;

            // Rastgele sayı üretici
            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            (function frame() {
                // Her karede biraz zaman geçsin
                var timeLeft = animationEnd - Date.now();

                // Loop (Sonsuz döngü)
                // Buradaki 'ticks' konfetinin ne kadar süre ekranda kalacağını belirler
                confetti({
                    particleCount: 1, // Her karede üretilen parça sayısı (az tutarak yağmur efekti veriyoruz)
                    startVelocity: 0, // Hız 0, yer çekimi ile düşecekler
                    ticks: 300,       // Ekranda kalma süresi (uzun tutuyoruz ki aşağı kadar insin)
                    origin: {
                        x: Math.random(), // Yatayda rastgele bir konum
                        // y: -0.1 diyerek ekranın hemen üstünden başlatıyoruz
                        y: -0.1
                    },
                    colors: ['#ffffff', '#FFD700', '#FFA500'], // Renkler: Beyaz, Altın, Turuncu
                    shapes: ['circle', 'square'], // Şekiller
                    gravity: 0.6,    // Yer çekimi hızı
                    scalar: 0.8,     // Parçacık boyutu
                    drift: 0,        // Sağa sola savrulma (0 düz düşer)
                });

                // Animasyonu sürekli tekrarla (Sonsuz Döngü)
                requestAnimationFrame(frame);
            }());
        </script>
        </body>
</html>