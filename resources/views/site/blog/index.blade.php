@extends('layouts.site')

@section('content')
@include('site.components.page-header')

<div class="page-blog">
    <div class="container">
        <div class="row">
            
            @if($blogs->count() > 0)
                @foreach($blogs as $blog)
                    <div class="col-lg-4 col-md-6">
                        {{-- Animasyon gecikmesini her eleman için 0.2sn artırıyoruz --}}
                        <div class="post-item wow fadeInUp" data-wow-delay="{{ 0.1 + ($loop->index * 0.1) }}s">
                            
                            <div class="post-featured-image">
                                <a href="{{ route('site.blog.detail', $blog->slug) }}" data-cursor-text="İncele">
                                    <figure class="image-anime">
                                        @if($blog->img)
                                            <img src="{{ asset('uploads/' . $blog->img) }}" alt="{{ $blog->title }}">
                                        @else
                                            
                                            <img src="{{ asset('assets/images/no-blog-img.webp') }}" alt="Varsayılan Resim">
                                        @endif
                                    </figure>
                                </a>
                            </div>
                            <div class="blog-item-body">
                                <div class="post-item-content">
                                    <h2>
                                        <a href="{{ route('site.blog.detail', $blog->slug) }}">
                                            {{ $blog->title }}
                                        </a>
                                    </h2>
                                </div>
                                <div class="blog-item-btn">
                                    <a href="{{ route('site.blog.detail', $blog->slug) }}" class="readmore-btn">Devamını Oku</a>
                                </div>
                                </div>
                            </div>
                        </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info">Henüz blog yazısı eklenmemiş.</div>
                </div>
            @endif

            <div class="col-lg-12">
                <div class="page-pagination wow fadeInUp" data-wow-delay="0.5s">
                    {{-- Laravel Pagination Linkleri --}}
                    {{-- Teman Bootstrap 5 kullanıyorsa bu uyumlu olacaktır --}}
                    {{ $blogs->links('pagination::bootstrap-5') }}
                </div>
                </div>
        </div>
    </div>
</div>
@endsection