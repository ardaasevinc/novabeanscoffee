@if(isset($setting))
    <footer class="main-footer parallaxie">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-contact-list">
                        {{-- TELEFON VE EMAIL --}}
                        <div class="footer-contact-item">
                            <div class="icon-box">
                                <img src="{{ asset('assets/images/icon-phone-accent.svg') }}" alt="Telefon">
                            </div>
                            <div class="footer-contact-detail">
                                <h3>Bize Ulaşın</h3>
                                @if($setting->phone)
                                    <p>T. <a href="tel:{{ str_replace(' ', '', $setting->phone) }}">{{ $setting->phone }}</a>
                                    </p>
                                @endif
                                @if($setting->email)
                                    <p>M. <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a></p>
                                @endif
                            </div>
                            <div class="footer-contact-button">
                                <a href="{{ route('site.contact') }}" class="btn-default btn-highlighted">İletişime Geç</a>
                            </div>
                        </div>

                        {{-- ADRES --}}
                        <div class="footer-contact-item">
                            <div class="icon-box">
                                <img src="{{ asset('assets/images/icon-location-accent.svg') }}" alt="Konum"
                                    style="height:80px;">
                            </div>
                            <div class="footer-contact-detail">
                                <h3>Adres</h3>
                                {{-- RichEditor olduğu için {!! !!} kullandık --}}
                                <div style="color: #fff; opacity: 0.8;">
                                    {!! $setting->address !!}
                                </div>
                            </div>
                            <div class="footer-contact-button">
                                {{-- Adresi Google Maps'te aratacak dinamik link --}}
                                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode(strip_tags($setting->address)) }}"
                                    target="_blank" class="btn-default btn-highlighted">Yol Tarifi</a>
                            </div>
                        </div>

                        {{-- ÇALIŞMA SAATLERİ (Modelde bu alan olmadığı için sabit bırakıldı) --}}
                        <div class="footer-contact-item">
                            <div class="icon-box">
                                <img src="{{ asset('assets/images/icon-clock-accent.svg') }}" alt="Çalışma Saatleri">
                            </div>
                            <div class="footer-contact-detail">
                                <h3>Çalışma Saatlerimiz</h3>
                                <p>Haftaiçi : 08.30 - 02.00</p>
                                <p>Haftasonu : 08.30 - 02.00</p>
                                <p>Mutfak Kapanış : 23:00</p>
                            </div>
                            <div class="footer-contact-button">
                                <a href="{{ route('site.reservation') }}"
                                    class="btn-default btn-highlighted">Rezervasyon</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="footer-copyright">
                        {{-- COPYRIGHT --}}
                        <div class="footer-copyright-text order-md-1 order-3">
                            <p>© {{ now()->year }}
                                {{ $setting->footer_text ? strip_tags($setting->footer_text) : 'Nova Beans Coffee' }}

                        </div>

                        {{-- LOGO --}}
                        <div class="footer-logo order-md-2 order-1">
                            @if($setting->logo)
                                <img src="{{ asset('uploads/' . $setting->logo) }}" alt="Logo">
                            @else
                                <img src="{{ asset('assets/images/logo.svg') }}" alt="Varsayılan Logo">
                            @endif
                        </div>

                        {{-- SOSYAL MEDYA --}}
                        <div class="footer-social-links order-md-3 order-2">
                           <ul>
    {{-- WhatsApp: Sadece sayıları filtrelediği için protokol eklemeye gerek yok --}}
    @if($setting?->phone)
        <li>
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $setting->phone) }}" target="_blank" title="WhatsApp">
                <i class="fa-brands fa-whatsapp"></i>
            </a>
        </li>
    @endif

    {{-- Instagram --}}
    @if($setting?->instagram_url)
        <li>
            @php
                $instagramUrl = str_starts_with($setting->instagram_url, 'http') ? $setting->instagram_url : 'https://' . $setting->instagram_url;
            @endphp
            <a href="{{ $instagramUrl }}" target="_blank" title="Instagram">
                <i class="fa-brands fa-instagram"></i>
            </a>
        </li>
    @endif

    {{-- Facebook --}}
    @if($setting?->facebook_url)
        <li>
            @php
                $facebookUrl = str_starts_with($setting->facebook_url, 'http') ? $setting->facebook_url : 'https://' . $setting->facebook_url;
            @endphp
            <a href="{{ $facebookUrl }}" target="_blank" title="Facebook">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
        </li>
    @endif

    {{-- X (Twitter) --}}
    @if($setting?->x_url)
        <li>
            @php
                $xUrl = str_starts_with($setting->x_url, 'http') ? $setting->x_url : 'https://' . $setting->x_url;
            @endphp
            <a href="{{ $xUrl }}" target="_blank" title="X">
                <i class="fa-brands fa-x-twitter"></i>
            </a>
        </li>
    @endif
</ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endif