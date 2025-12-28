<!-- Header Start -->
	<header class="main-header">
		<div class="header-sticky">
			<nav class="navbar navbar-expand-lg">
				<div class="container">
					<!-- Logo Start -->
					<a class="navbar-brand" href="./">
						<img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" style="height: 60px;">
					</a>
					<!-- Logo End -->

					<!-- Main Menu Start -->
					<div class="collapse navbar-collapse main-menu">
                        
                        <div class="nav-menu-wrapper">
                            <ul class="navbar-nav mr-auto" id="menu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('site.index') }}">Anasayfa</a></li>                                                              
                                <li class="nav-item"><a class="nav-link" href="{{ route('site.about') }}">Hakkımızda</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('site.services') }}">Hizmetler</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('site.menu') }}">Menu</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('site.contact') }}">Bize Ulaşın</a></a></li>  
                                <li class="nav-item"><a class="nav-link" href="{{ url('https://novabeansscoffee.com') }}">NovaBeans</a></li>                           
                                <li class="nav-item highlighted-menu"><a class="nav-link" href="book-table.html">Book A Table</a></li>                             
                            </ul>
                        </div>

                        <!-- Header Button Box Start -->
                        <div class="header-button-box">
                            <!-- Header Btn Start -->
                            <div class="header-btn">
                               <a href="{{ route('site.book-table') }}" class="btn-default btn-highlighted">Rezervasyon</a>
                            </div>
                            <!-- Header Btn End -->

                            <!-- Header Sidebar Btn Start -->
                            <div class="header-sidebar-btn">
                                <!-- Toggle Button trigger modal Start -->
                                <button class="btn btn-popup" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><img src="assets/images/header-sidebar-btn.svg" alt=""></button>
                                <!-- Toggle Button trigger modal End -->

                                <!-- Header Sidebar Start -->
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight">
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    
                                    <!-- Offcanvas Body Start -->
                                    <div class="offcanvas-body">
                                        <!-- Header Title Box Start -->
                                        <div class="header-title-box">
                                            <h2>welcome to roast coffee & tea</h2>
                                            <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae.</p>
                                        </div>
                                        <!-- Header Title Box End -->

                                        <!-- Header Sidebar Info Start -->
                                        <div class="header-sidebar-info">
                                            <h2><a href="tel:+123456789">+123 456 789</a></h2>
                                            <ul>
                                                <li>62 Big Tree St, Livonia, New York 14487, USA</li>
                                                <li><a href="mailto:info@domainname.com">info@domainname.com</a></li>
                                            </ul>
                                        </div>
                                        <!-- Header Sidebar Info End -->

                                        <!-- Header Sidebar Timing Start -->
                                        <div class="header-sidebar-timing">
                                            <ul>
                                                <li>Monday - Friday : 8.00am - 21.00pm</li>
                                                <li>Saturday - Sunday : 9.00am - 22.00pm</li>
                                                <li>Holiday : Closed</li>
                                            </ul>
                                        </div>
                                        <!-- Header Sidebar Timing End -->
                                        
                                        <!-- Header Sidebar Social List Start -->
                                        <div class="header-sidebar-social-list">
                                            <ul>
                                                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                                <li><a href="#"><i class="fa-brands fa-dribbble"></i></a></li>
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