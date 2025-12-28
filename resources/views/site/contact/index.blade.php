@extends('layouts.site')

@section('content')
<div class="page-contact-us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="contact-information">
                        <div class="section-title">
                            <h3 class="wow fadeInUp">İletişim</h3>
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Bizimle İletişime Geçin</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Sizden haber almaktan mutluluk duyarız! Sorularınız, rezervasyon talepleriniz veya iş birlikleriniz için bize aşağıdaki kanallardan dilediğiniz zaman ulaşabilirsiniz.</p>
                        </div>
                        <div class="contact-info-body">
                            <div class="contact-info-box-1 wow fadeInUp" data-wow-delay="0.4s">
                                <div class="contact-info-item">
                                    <div class="icon-box">
                                        <img src="{{ asset('assets/images/icon-phone-accent.svg') }}" alt="Telefon İkonu">
                                    </div>
                                    <div class="contact-item-content">
                                        <h3>Telefon Numarası</h3>
                                        <p><a href="tel:+902120000000">+90 212 000 00 00</a></p>
                                    </div>
                                    </div>
                                <div class="contact-info-item">
                                    <div class="icon-box">
                                        <img src="{{ asset('assets/images/icon-mail-accent.svg') }}" alt="Mail İkonu">
                                    </div>
                                    <div class="contact-item-content">
                                        <h3>E-posta Adresi</h3>
                                        <p><a href="mailto:info@novakitchen.com">info@novakitchen.com</a></p>
                                    </div>
                                    </div>
                                </div>
                            <div class="contact-info-box-2 wow fadeInUp" data-wow-delay="0.6s">
                                <div class="contact-info-item">
                                    <div class="icon-box">
                                        <img src="{{ asset('assets/images/icon-location-accent.svg') }}" alt="Konum İkonu">
                                    </div>
                                    <div class="contact-item-content">
                                        <h3>Adres</h3>
                                        <p>Ferhatpaşa Mahallesi Mescit Sokak Çağlayan Ege Ticaret Merkezi No:1 Kat: 2 Çatalca / İstanbul</p>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="col-lg-6">
                    <div class="contact-us-form">
                        <div class="contact-form-content">
                            <h3 class="wow fadeInUp">Bize Mesaj Gönderin</h3>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Görüşleriniz bizim için değerli. Soru, görüş ve önerilerinizi aşağıdaki formu doldurarak bize iletebilirsiniz. Ekibimiz en kısa sürede size dönüş yapacaktır.</p>
                        </div>
                        <div class="contact-form">
                            <form id="contactForm" action="#" method="POST" data-toggle="validator" class="wow fadeInUp" data-wow-delay="0.4s">
                                <div class="row">
                                    <div class="form-group col-md-6 mb-5">
                                        <input type="text" name="fname" class="form-control" id="fname" placeholder="Adınız" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
    
                                    <div class="form-group col-md-6 mb-5">
                                        <input type="text" name="lname" class="form-control" id="lname" placeholder="Soyadınız" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
    
                                    <div class="form-group col-md-6 mb-5">
                                        <input type="email" name ="email" class="form-control" id="email" placeholder="E-posta Adresi" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    
                                    <div class="form-group col-md-6 mb-5">
                                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Telefon Numarası" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
    
                                    <div class="form-group col-md-12 mb-5">
                                        <textarea name="message" class="form-control" id="message" rows="3" placeholder="Mesajınız"></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
    
                                    <div class="col-lg-12">
                                        <div class="contact-form-btn">
                                            <button type="submit" class="btn-default">Mesajı Gönder</button>
                                            <div id="msgSubmit" class="h3 hidden"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                         </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    
    <!-- Google Map Section Start -->
    <div class="google-map">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Google Map IFrame Start -->
                    <div class="google-map-iframe">
                       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12018.367462286567!2d28.44135858715822!3d41.14343480000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14b54511450974d9%3A0x19e29aef6922b992!2sNova%20Beans%20Coffee!5e0!3m2!1str!2str!4v1766951226368!5m2!1str!2str" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <!-- Google Map IFrame End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Google Map Section End -->
@endsection