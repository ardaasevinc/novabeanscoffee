@extends('layouts.site')
@section('content')
<!-- error section start -->
    <div class="error-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Error Page Image Start -->
                    <div class="error-page-image wow fadeInUp">
                        <img src="assets/images/404-error-img.png" alt="">
                    </div>
                    <!-- Error Page Image End -->
                    
                    <!-- Error Page Content Start -->
                    <div class="error-page-content">
                        <div class="section-title">
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Oops! page not found</h2>
                        </div>
                        <div class="error-page-content-body">
                            <p class="wow fadeInUp" data-wow-delay="0.25s">We've searched far and wide but couldn't find your coffee fix.Let us brew a path to help you discover something delightful.</p>
                            <a class="btn-default wow fadeInUp" data-wow-delay="0.5s" href="./"><span>back to home</span></a>
                        </div>
                    </div>
                    <!-- Error Page Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- error section end -->
@endsection