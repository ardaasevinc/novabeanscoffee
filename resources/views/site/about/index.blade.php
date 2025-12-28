@extends('layouts.site')

@section('content')
<!-- About us Section Start -->
    <div class="about-us">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- About us Content Start -->
                    <div class="about-us-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">about us</h3>
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Bringing people together, one cup at a time</h2>
                        </div>
                        <!-- Section Title End -->
                         
                        <!-- About Body List Start -->
                        <div class="about-body-list">
                            <!-- About Body Item Start -->
                            <div class="about-body-item wow fadeInUp" data-wow-delay="0.2s">
                                <div class="icon-box">
                                    <img src="assets/images/icon-about-body-item-1.svg" alt="">
                                </div>
                                <div class="about-body-list-content">
                                    <h3>Food delivery</h3>
                                    <p>With our fast and reliable food delivery service, your favorite coffee, snacks, and treats are just a click away.</p>
                                </div>
                            </div>
                            <!-- About Body Item End -->
                            
                            <!-- About Body Item Start -->
                            <div class="about-body-item wow fadeInUp" data-wow-delay="0.4s">
                                <div class="icon-box">
                                    <img src="assets/images/icon-about-body-item-2.svg" alt="">
                                </div>
                                <div class="about-body-list-content">
                                    <h3>Event elegance</h3>
                                    <p>Host your special moments with us! From intimate gatherings to vibrant celebrations offers.</p>
                                </div>
                            </div>
                            <!-- About Body Item End -->
                        </div>
                        <!-- About Body List End -->
                        
                        <!-- About Us Footer Start -->
                        <div class="about-us-footer wow fadeInUp" data-wow-delay="0.6s">
                            <!-- About Button Start -->
                            <div class="about-btn">
                                <a href="contact.html" class="btn-default">contact us</a>
                            </div>
                            <!-- About Button End -->
                            
                            <!-- Video Play Button Start -->
                            <div class="video-play-button">
                                <a href="https://www.youtube.com/watch?v=Y-x0efG1seA" class="popup-video" data-cursor-text="Play">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                                <p>watch video</p>
                            </div>
                            <!-- Video Play Button End -->
                        </div>
                        <!-- About Us Footer End -->
                    </div>
                    <!-- About us Content End -->
                </div>

                <div class="col-lg-6">
                    <!-- About Us Image Start -->
                    <div class="about-us-image">
                        <!-- About Us Image Start -->
                        <div class="about-us-img">
                            <figure class="image-anime">
                                <img src="assets/images/about-us-image.jpg" alt="">
                            </figure>
                        </div>
                        <!-- About Us Image End -->
                        
                        <!-- Opening Time Box Start -->
                        <div class="opening-time-box">
                            <!-- Icon Box Start -->
                            <div class="icon-box">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <!-- Icon Box End -->
                            
                            <!-- Opening Time Content Start -->
                            <div class="opening-time-content">
                                <h3>Open hours</h3>
                                <ul>
                                    <li>Monday - Friday<span>09:30 - 7:30</span></li>
                                    <li>Saturday<span>10:30 - 5:00</span></li>
                                    <li>Sunday<span>24 hours open</span></li>
                                </ul>
                            </div>
                            <!-- Opening Time Content End -->
                        </div>
                        <!-- About Menu Box End -->
                    </div>
                    <!-- Opening Time Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- About us Section End -->

    @include('site.components.why-choose')
    @include('site.components.intro-video')
    @include('site.components.our-faqs')

@endsection