<div class="topbar">
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
                        <li>
                            <a href="{{ $setting?->instagram_url }}" target="_blank">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                        
                        {{-- <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-dribbble"></i></a></li> --}}
                       
                        </ul>
                        </div>
                </div>
        </div>
        </div>
        </div>