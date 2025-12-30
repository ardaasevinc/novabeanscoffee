<div class="cta-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cta-box-content">
                    <div class="section-title">
                        <h3 class="wow fadeInUp">Lezzet Parmaklarınızın Ucunda</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Nova Beans Coffee Dijital Deneyimi</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">Uygulama indirme veya güncelleme derdi olmadan,
                            Nova Kitchen'a her an
                            ulaşın. Web sitemizi telefonunuzun ana ekranına ekleyerek (PWA), menümüzü inceleyebilir,
                            kolayca rezervasyon oluşturabilirsiniz.</p>
                    </div>
                    <div class="cta-box-buttons wow fadeInUp" data-wow-delay="0.4s">
                        <a href="{{ route('site.menu') }}" class="btn-default"><i class="fa-solid fa-book-open"></i>
                            Menüyü İncele</a>
                        <a id="installBtn" href="javascript:void(0);" style="display:none;" class="btn-default">
                            <i class="fa-solid fa-mobile-screen-button"></i> Ana Ekrana Ekle
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
let deferredPrompt;
const installBtn = document.getElementById('installBtn');

window.addEventListener('beforeinstallprompt', (e) => {
    // Tarayıcı otomatik istemini durdur
    e.preventDefault();
    deferredPrompt = e;
    
    // Butonu kullanıcıya göster
    installBtn.style.display = 'inline-flex';

    installBtn.addEventListener('click', () => {
        // Yükleme penceresini aç
        deferredPrompt.prompt();
        
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('Kullanıcı kabul etti');
                installBtn.style.display = 'none'; // Yüklendiyse butonu gizle
            }
            deferredPrompt = null;
        });
    });
});

// Zaten yüklüyse butonu gizle
window.addEventListener('appinstalled', () => {
    installBtn.style.display = 'none';
});


if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js');
}


</script>

