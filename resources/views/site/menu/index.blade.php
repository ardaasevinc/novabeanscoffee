@extends('layouts.site')

@section('content')
@include('site.components.page-header')

<div class="page-menu">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-menu-box">
                    
                    @if($menuCategories->count() > 0)
                        @foreach($menuCategories as $category)
                            <div class="page-menu-item">
                                <div class="section-title">
                                    <h3 class="wow fadeInUp">{{ $category->title }}</h3>
                                    @if($category->desc)
                                        <h2 class="text-anime-style-3" data-cursor="-opaque">
                                            {!! strip_tags($category->desc) !!}
                                        </h2>
                                    @endif
                                </div>
                                @if($category->img)
                                    <div class="page-menu-image">
                                        <figure class="image-anime reveal">
                                            <img src="{{ asset('uploads/' . $category->img) }}" alt="{{ $category->title }}">
                                        </figure>
                                    </div>
                                @endif
                                <div class="page-menu-list">
                                    {{-- 
                                        Ürünleri 2 sütuna bölmek için split(2) kullanıyoruz.
                                        Eğer ürün yoksa boş döner, hata vermez.
                                    --}}
                                    @foreach($category->menus->split(2) as $chunk)
                                        <div class="our-menu-list">
                                            @foreach($chunk as $menu)
                                                {{-- Animasyon gecikmesini döngüye göre ayarlıyoruz --}}
                                                <div class="menu-list-item wow fadeInUp" data-wow-delay="{{ 0.2 * $loop->index }}s">
                                                    <div class="menu-list-image">
                                                        <figure>
                                                            @if($menu->img)
                                                                <img src="{{ asset('uploads/' . $menu->img) }}" alt="{{ $menu->title }}">
                                                            @else
                                                                {{-- Placeholder --}}
                                                                <img src="{{ asset('assets/images/original-coffee-img-1.png') }}" alt="Menu Item">
                                                            @endif
                                                        </figure>
                                                    </div>
                                                    <div class="menu-item-body">
                                                        <div class="menu-item-title">
                                                            <h3>{{ $menu->title }}</h3>
                                                            <hr>
                                                            <span>{{ $menu->price }} ₺</span>
                                                        </div>
                                                        <div class="menu-item-content">
                                                            {{-- Açıklama RichText olabilir, strip_tags ile temizliyoruz --}}
                                                            <p>{!! strip_tags($menu->desc) !!}</p>
                                                        </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                        </div>
                                    @endforeach
                                </div>
                                </div>
                            @endforeach
                    @else
                        <div class="text-light">
                            Henüz menü eklenmemiş.
                        </div>
                    @endif

                </div>
                </div>
        </div>
    </div>
</div>
@endsection