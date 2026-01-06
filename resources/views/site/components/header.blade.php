<!-- Header Start -->
<header class="main-header">
    <div class="header-sticky">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Logo Start -->
                <a class="navbar-brand" href="{{ route('site.index') }}">
                    <img src="{{ asset('uploads/'.$setting?->logo) }}" alt="Logo" style="height: 50px;">
                </a>
                <!-- Logo End -->

                <!-- Main Menu Start -->
                <div class="collapse navbar-collapse main-menu">

                    <div class="nav-menu-wrapper">
                        <ul class="navbar-nav mr-auto" id="menu">
                            <li class="nav-item"><a class="nav-link" href="{{ route('site.index') }}">Anasayfa</a></li>

                            {{-- HAKKIMIZDA: Veritabanında herhangi bir kayıt varsa göster --}}
                            @if(\App\Models\About::exists())
                                <li class="nav-item"><a class="nav-link" href="{{ route('site.about') }}">Hakkımızda</a>
                                </li>
                            @endif

                            {{-- HİZMETLER: Yayında olan en az 1 hizmet varsa göster --}}
                            @if(\App\Models\Service::where('is_published', true)->exists())
                                <li class="nav-item"><a class="nav-link" href="{{ route('site.services') }}">Hizmetler</a>
                                </li>
                            @endif

                            {{-- MENÜ: Yayında olan en az 1 menü kategorisi varsa göster --}}
                            @if(\App\Models\MenuCategory::where('is_published', true)->exists())
                                <li class="nav-item"><a class="nav-link" href="{{ route('site.menu') }}">Menu</a></li>
                            @endif

                            {{-- BLOG: Yayında olan en az 1 blog yazısı varsa göster --}}
                            @if(\App\Models\Blog::where('is_published', true)->exists())
                                <li class="nav-item"><a class="nav-link" href="{{ route('site.blog') }}">Blog</a></li>
                            @endif

                           

                           

                           
                        </ul>
                    </div>

                    <!-- Header Button Box Start -->
                    <div class="header-button-box">
                        <!-- Header Btn Start -->
                        <div class="header-btn">
                            <a href="{{ route('site.reservation') }}"
                                class="btn-default btn-highlighted">Bize Ulaşın</a>
                        </div>
                        <!-- Header Btn End -->

                        <!-- Header Sidebar Btn Start -->
                        <div class="header-sidebar-btn">
                            <!-- Toggle Button trigger modal Start -->
                            <button class="btn btn-popup" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><img
                                    src="{{ asset('assets/images/header-sidebar-btn.svg') }}" alt=""></button>
                            <!-- Toggle Button trigger modal End -->

                            <!-- Header Sidebar Start -->
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight">
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>

                                <!-- Offcanvas Body Start -->
                                <div class="offcanvas-body">
                                    <!-- Header Title Box Start -->
                                    <div class="header-title-box">
                                        <h2>Nova Beans Coffee <br>Hoş Geldiniz.</h2>
                                        <p>{{ $setting?->slogan }}</p>
                                    </div>
                                    <!-- Header Title Box End -->

                                    <!-- Header Sidebar Info Start -->
                                    <div class="header-sidebar-info">
                                        <h2><a href="{{ $setting?->phone }}">{{ $setting?->phone }}</a></h2>
                                        <ul>
                                            <li>{{ strip_tags($setting?->address) }}</li>
                                            <li><a href="mailto:{{ $setting?->email }}">{{ $setting?->email }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Header Sidebar Info End -->

                                    <!-- Header Sidebar Timing Start -->
                                    <div class="header-sidebar-timing">
                                        <ul>
                                            <li>Haftaiçi : 08.30 - 02.00</li>
                                            <li>Haftasonu : 08.30 - 02.00</li>
                                            <li>Mutfak Kapanış : 23:00</li>
                                        </ul>
                                    </div>
                                    <!-- Header Sidebar Timing End -->

                                    <!-- Header Sidebar Social List Start -->
                                    <div class="header-sidebar-social-list">
                                        <ul>
                                            <li><a href="{{ url('https://instagram.com/novabeanscoffee') }}"><i
                                                        class="fa-brands fa-instagram"></i></a></li>
                                            {{-- <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fa-brands fa-dribbble"></i></a></li> --}}
                                        </ul>
                                    </div>
                                    <!-- Header Sidebar Social List End -->
                                </div>
                                <!-- Offcanvas Body End -->
                            </div>
                            <!-- Header Sidebar End -->
                        </div>
                        <!-- Header Sidebar Btn End -->
                    </div>
                    <!-- Header Button Box End -->
                </div>
                <!-- Main Menu End -->
                <div class="navbar-toggle"></div>
            </div>
        </nav>
        <div class="responsive-menu"></div>
    </div>
</header>
<!-- Header End -->