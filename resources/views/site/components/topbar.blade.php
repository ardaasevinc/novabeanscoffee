<div class="topbar d-none d-md-block">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-9">
                <div class="topbar-contact-info">
                    <ul>
                        <li>
                            <a href="mailto:info@novakitchen.com.tr">
                                <img src="{{ asset('assets/images/icon-mail.svg') }}" alt="Email">
                                {{ $setting?->email }}
                            </a>
                        </li>
                        <li>
                            <img src="{{ asset('assets/images/icon-location.svg') }}" alt="Konum">
                            {{ strip_tags($setting?->address) }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3">
                <div class="topbar-social-links">
                    <ul>
                       
                        @if($setting?->phone)
                            <li>
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $setting->phone) }}" target="_blank"
                                    title="WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            </li>
                        @endif

                        
                        @if($setting?->instagram_url)
                            <li>
                                <a href="{{ $setting->instagram_url }}" target="_blank" title="Instagram">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            </li>
                        @endif

                        
                        @if($setting?->facebook_url)
                            <li>
                                <a href="{{ $setting->facebook_url }}" target="_blank" title="Facebook">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            </li>
                        @endif

                       
                        @if($setting?->x_url)
                            <li>
                                <a href="{{ $setting->x_url }}" target="_blank" title="X">
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