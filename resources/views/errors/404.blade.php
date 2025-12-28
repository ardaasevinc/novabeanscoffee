@extends('layouts.site')
@section('content')
<!-- error section start -->
    <div class="error-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Error Page Image Start -->
                    <div class="error-page-image wow fadeInUp">
                        <img src="assets/images/404-image.png" alt="">
                    </div>
                    <!-- Error Page Image End -->
                    
                    <!-- Error Page Content Start -->
                    <div class="error-page-content">
                        <div class="section-title">
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Oops! Aradığınız sayfayı bulamadık.</h2>
                        </div>
                        <div class="error-page-content-body">
                            <p class="wow fadeInUp" data-wow-delay="0.25s">Dört bir yanı aradık ama aradığınız lezzeti bulamadık. İzin verin, sizi enfes bir ziyafete götürecek yolu tarif edelim.</p>
                            <a class="btn-default wow fadeInUp" data-wow-delay="0.5s" href="./"><span>Nova Kitchen</span></a>
                        </div>
                    </div>
                    <!-- Error Page Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- error section end -->
@endsection