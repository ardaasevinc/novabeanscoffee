@extends('layouts.site')

@section('content')
    {{-- Page Header Component'i --}}
    {{-- Controller'dan gönderdiğimiz $page_title burada başlık olarak kullanılır --}}
    @include('site.components.page-header')

    <div class="page-single-post">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    {{-- 1. Blog Görseli --}}
                    @if($blog->img)
                        <div class="post-image">
                            <figure class="image-anime reveal">
                                <img src="{{ asset('uploads/' . $blog->img) }}" alt="{{ $blog->title }}">
                            </figure>
                        </div>
                    @endif

                    <div class="post-content">
                        {{-- 2. Blog İçeriği (Rich Text) --}}
                        <div class="post-entry wow fadeInUp">
                            {{-- {!! !!} kullanarak HTML etiketlerini çalıştırıyoruz --}}
                            {!! $blog->desc !!}
                        </div>

                        {{-- Alt Kısım: Etiketler ve Paylaşım --}}
                        <div class="post-tag-links">
                            <div class="row align-items-center">

                                {{-- 3. Etiketler (Tags) --}}
                                <div class="col-lg-8">
                                    <div class="post-tags wow fadeInUp" data-wow-delay="0.2s">
                                        <span class="tag-links">
                                            Etiketler:
                                            @if(!empty($blog->tags) && is_array($blog->tags))
                                                @foreach($blog->tags as $tag)
                                                    <a href="javascript:void(0)">{{ $tag }}</a>
                                                @endforeach
                                            @else
                                                <span>Etiket yok</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                {{-- 4. Sosyal Medya Paylaşım Butonları --}}
                                <div class="col-lg-4">
                                    <div class="post-social-sharing wow fadeInUp" data-wow-delay="0.2s">
                                        <ul>
                                            {{-- Facebook Paylaş --}}
                                            <li>
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                                    target="_blank">
                                                    <i class="fa-brands fa-facebook-f"></i>
                                                </a>
                                            </li>

                                            {{-- Twitter (X) Paylaş --}}
                                            <li>
                                                <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $blog->title }}"
                                                    target="_blank">
                                                    <i class="fa-brands fa-x-twitter"></i>
                                                </a>
                                            </li>

                                            {{-- LinkedIn Paylaş --}}
                                            <li>
                                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}"
                                                    target="_blank">
                                                    <i class="fa-brands fa-linkedin-in"></i>
                                                </a>
                                            </li>

                                            {{-- WhatsApp Paylaş --}}
                                            <li>
                                                <a href="https://api.whatsapp.com/send?text={{ $blog->title }} - {{ url()->current() }}"
                                                    target="_blank">
                                                    <i class="fa-brands fa-whatsapp"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection