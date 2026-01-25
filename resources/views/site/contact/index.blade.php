@extends('layouts.site')

@section('content')
    @include('site.components.page-header')

    <div class="page-contact-us">
        <div class="container">
            <div class="row align-items-center">

                {{-- SOL KOLON: İletişim Bilgileri (Setting Modelinden) --}}
                <div class="col-lg-6">
                    <div class="contact-information">
                        <div class="section-title">
                            <h3 class="wow fadeInUp">İletişim</h3>
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Bizimle İletişime Geçin</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Sizden haber almaktan mutluluk duyarız!
                                Sorularınız, rezervasyon talepleriniz veya iş birlikleriniz için bize aşağıdaki kanallardan
                                dilediğiniz zaman ulaşabilirsiniz.</p>
                        </div>

                        @if(isset($setting))
                            <div class="contact-info-body">
                                <div class="contact-info-box-1 wow fadeInUp" data-wow-delay="0.4s">

                                    {{-- Telefon --}}
                                    <div class="contact-info-item">
                                        <div class="icon-box">
                                            <img src="{{ asset('assets/images/icon-phone-accent.svg') }}" alt="Telefon İkonu">
                                        </div>
                                        <div class="contact-item-content">
                                            <h3>Telefon Numarası</h3>
                                            <p>
                                                <a href="tel:{{ str_replace(' ', '', $setting->phone) }}">
                                                    {{ $setting->phone ?? '+90 --- --- -- --' }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>

                                    {{-- E-Posta --}}
                                    <div class="contact-info-item">
                                        <div class="icon-box">
                                            <img src="{{ asset('assets/images/icon-mail-accent.svg') }}" alt="Mail İkonu">
                                        </div>
                                        <div class="contact-item-content">
                                            <h3>E-posta Adresi</h3>
                                            <p>
                                                <a href="mailto:{{ $setting->email }}">
                                                    {{ $setting->email ?? 'info@site.com' }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Adres --}}
                                <div class="contact-info-box-2 wow fadeInUp" data-wow-delay="0.6s">
                                    <div class="contact-info-item">
                                        <div class="icon-box">
                                            <img src="{{ asset('assets/images/icon-location-accent.svg') }}" alt="Konum İkonu">
                                        </div>
                                        <div class="contact-item-content">
                                            <h3>Adres</h3>
                                            {{-- Adres RichEditor olduğu için {!! !!} kullandık --}}
                                            <div style="color: #636363;">
                                                {!! $setting->address ?? 'Adres bilgisi girilmedi.' !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- SAĞ KOLON: İletişim Formu --}}
                <div class="col-lg-6">
                    <div class="contact-us-form">
                        <div class="contact-form-content">
                            <h3 class="wow fadeInUp">Bize Mesaj Gönderin</h3>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Görüşleriniz bizim için değerli. Soru, görüş ve
                                önerilerinizi aşağıdaki formu doldurarak bize iletebilirsiniz.</p>
                        </div>

                        {{-- Başarı Mesajı --}}
                        @if(session('success'))
                            <div class="text-success mb-5">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Hata Mesajları --}}
                        @if ($errors->any())
                            <div class="alert alert-danger wow fadeInUp">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="contact-form">
                            {{-- ID'yi contactForm yerine laravelContactForm yaptık --}}
                            <form id="laravelContactForm" action="{{ route('contact.store') }}" method="POST"
                                class="wow fadeInUp" data-wow-delay="0.4s">
                                @csrf
                                @honeypot
                                <div class="row">
                                    <div class="form-group col-md-6 mb-5">
                                        <input type="text" name="fname" class="form-control" id="fname" placeholder="Adınız"
                                            value="{{ old('fname') }}" required>
                                    </div>

                                    <div class="form-group col-md-6 mb-5">
                                        <input type="text" name="lname" class="form-control" id="lname"
                                            placeholder="Soyadınız" value="{{ old('lname') }}" required>
                                    </div>

                                    <div class="form-group col-md-6 mb-5">
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="E-posta Adresi" value="{{ old('email') }}" required>
                                    </div>

                                    <div class="form-group col-md-6 mb-5">
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            placeholder="Telefon Numarası" value="{{ old('phone') }}" required>
                                    </div>

                                    <div class="form-group col-md-12 mb-5">
                                        <textarea name="message" class="form-control" id="message" rows="3"
                                            placeholder="Mesajınız" required>{{ old('message') }}</textarea>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="contact-form-btn">
                                            <button type="submit" class="btn-default">
                                                Mesajı Gönder
                                            </button>
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

    {{-- Google Map Section --}}
    @if(isset($setting) && $setting->map)
        <div class="google-map">
            <div class="container mb-5">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="google-map-iframe">
                            {{-- Setting modelindeki iframe kodu buraya basılır --}}
                            {!! $setting->map !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection