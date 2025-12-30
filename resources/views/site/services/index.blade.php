@extends('layouts.site')

@section('content')
@include('site.components.page-header')

<div class="page-services">
    <div class="container">
        <div class="row">
            
            @if($services->count() > 0)
                @foreach($services as $service)
                    <div class="col-lg-4 col-md-6">
                        {{-- Animasyon gecikmesini her eleman için 0.2sn artırıyoruz --}}
                        <div class="service-item wow fadeInUp" data-wow-delay="{{ $loop->index * 0.2 }}s">
                            
                            <div class="icon-box">
                                @if($service->icon)
                                    {{-- İkonu uploads klasöründen çekiyoruz --}}
                                    <img src="{{ asset('uploads/' . $service->icon) }}" alt="{{ $service->title }}" style="height: 60px;">
                                @else
                                    {{-- Varsayılan ikon --}}
                                    <img src="{{ asset('assets/images/icon-service-nova.svg') }}" alt="Hizmet">
                                @endif
                            </div>

                            <div class="service-content">
                                <h3>
                                    <a href="{{ route('site.services.detail', $service->slug) }}">
                                        {{ $service->title }}
                                    </a>
                                </h3>
                                
                                {{-- Açıklamayı temizleyip kısaltıyoruz --}}
                                <p>{!! Str::limit(strip_tags($service->desc), 100) !!}</p>
                            </div>

                            <div class="service-readmore-btn">
                                <a href="{{ route('site.services.detail', $service->slug) }}" class="readmore-btn">Devamını Oku</a>
                            </div>
                        </div>
                        </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info wow fadeInUp">
                        Henüz hizmet eklenmemiş.
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection