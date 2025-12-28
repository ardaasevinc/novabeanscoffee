<!-- Main Footer Section Start -->
    <footer class="main-footer parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Footer Contact List Start -->
                    <div class="footer-contact-list">
                        <!-- Footer Contact Item Start -->
                        <div class="footer-contact-item">
                            <div class="icon-box">
                                <img src="assets/images/icon-phone-accent.svg" alt="">
                            </div>
                            <div class="footer-contact-detail">
                                <h3>Bize Ulaşın</h3>
                                <p>T. <a href="tel:+123456789">+123 456 789</a></p>
                                <p>M. <a href="mainto:info@domainname.com">info@novakitchen.com.tr</a></p>
                            </div>
                            <div class="footer-contact-button">
                                <a href="contact.html" class="btn-default btn-highlighted">Bize Ulaşın</a>
                            </div>
                        </div>
                        <!-- Footer Contact Item End -->

                        <!-- Footer Contact Item Start -->
                        <div class="footer-contact-item">
                            <div class="icon-box">
                                <img src="assets/images/icon-location-accent.svg" alt="logo" style="height:80px;">
                            </div>
                            <div class="footer-contact-detail">
                                <h3>adres</h3>
                                <p>Mescit Sokak Çağlayan Ege Ticaret Merkezi No:1 Kat: 2 İç Kapı No:206, Çatalca, İstanbul 34540
</p>
                            </div>
                            <div class="footer-contact-button">
                                <a href="{{ route('site.contact') }}" class="btn-default btn-highlighted">Yol Haritası</a>
                            </div>
                        </div>
                        <!-- Footer Contact Item End -->

                        <!-- Footer Contact Item Start -->
                        <div class="footer-contact-item">
                            <div class="icon-box">
                                <img src="assets/images/icon-clock-accent.svg" alt="">
                            </div>
                            <div class="footer-contact-detail">
                                <h3>Çalışma Saatlerimiz</h3>
                                <p>Haftanın her günü: 08.30 To 02.00</p>
                                <p>Mutfak Kapanışı 23.00</p>
                            </div>
                            <div class="footer-contact-button">
                                <a href="{{ route('site.book-table') }}" class="btn-default btn-highlighted">Rezervasyon</a>
                            </div>
                        </div>
                        <!-- Footer Contact Item End -->
                    </div>
                    <!-- Footer Contact List End -->
                </div>

                <div class="col-lg-12">
                    <!-- Footer Copyright Start -->
                    <div class="footer-copyright">
                        <!-- Footer Copyright Text Start -->
                        <div class="footer-copyright-text order-md-1 order-3">
                            <p> © {{ now()->year }} Nova Kitchen için özel tasarlanmıştır.<BR>Tüm Hakları Saklıdır.</p>
                        </div>
                        <!-- Footer Copyright Text End -->

                        <!-- Footer Logo Start -->
                        <div class="footer-logo order-md-2 order-1">
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="">
                        </div>
                        <!-- Footer Logo End -->

                        <!-- Footer Social Links Start -->
                        <div class="footer-social-links order-md-3 order-2">
                            <ul>
                                <li><a href="https://instagram.com/novabeanscoffee.com"><i class="fa-brands fa-instagram"></i></a></li>
                                {{-- <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-dribbble"></i></a></li> --}}
                            </ul>
                        </div>
                        <!-- Footer Social Links End -->
                    </div>
                    <!-- Footer Copyright End -->
                </div>
            </div>
        </div>
    </footer>
    <!-- Main Footer Section End -->