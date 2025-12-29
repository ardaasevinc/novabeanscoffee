@extends('layouts.site')

@section('content')
    {{-- Page Header --}}
    @include('site.components.page-header')

    <div class="page-single-post">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    {{-- 1. Blog Görseli --}}
                    @if(!empty($blog->img))
                        <div class="post-image">
                            <figure class="image-anime reveal">
                                {{-- Not: Eğer Filament default disk kullanıyorsa 'storage/' eklemek gerekebilir.
                                Senin yapına göre 'uploads/' bıraktım. --}}
                                <img src="{{ asset('uploads/' . $blog->img) }}" alt="{{ $blog->title }}">
                            </figure>
                        </div>
                    @endif

                    <div class="post-content">
                        {{-- 2. Blog İçeriği --}}
                        <div class="post-entry wow fadeInUp">
                            {!! $blog->desc ?? $blog->content !!}
                            {{-- Not: Veritabanında sütun adın 'content' ise $blog->content, 'desc' ise $blog->desc kullanır
                            --}}
                        </div>

                        {{-- Alt Kısım: Etiketler ve Paylaşım --}}
                        <div class="post-tag-links">
                            <div class="row align-items-center">

                                {{-- 3. Etiketler (Geliştirilmiş Yapı) --}}
                                <div class="col-lg-8">
                                    <div class="post-tags wow fadeInUp" data-wow-delay="0.2s">

                                        {{-- PHP Bloğu: Etiket verisini garantiye alıyoruz --}}
                                        @php
                                            $tags = $blog->tags;
                                            // Model cast çalışmadıysa ve string geldiyse diziye çevir
                                            if (is_string($tags)) {
                                                $tags = json_decode($tags, true);
                                            }
                                            // Hala dizi değilse boş dizi ata
                                            if (!is_array($tags)) {
                                                $tags = [];
                                            }
                                        @endphp

                                        {{-- Sadece etiket varsa "Etiketler:" yazısını göster --}}
                                        @if(count($tags) > 0)
                                            <span class="tag-links">
                                                <strong>Etiketler:</strong>
                                                @foreach($tags as $tag)
                                                    {{-- Filament bazen key=>value kaydeder, sadece değeri alıyoruz --}}
                                                    <a href="javascript:void(0)">{{ is_array($tag) ? implode('', $tag) : $tag }}</a>
                                                @endforeach
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- 4. Sosyal Medya Paylaşım (Türkçe Karakter Uyumlu) --}}
                                <div class="col-lg-4">
                                    <div class="post-social-sharing wow fadeInUp" data-wow-delay="0.2s">
                                        <ul>
                                            {{-- Facebook --}}
                                            <li>
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                                    target="_blank" title="Facebook'ta Paylaş">
                                                    <i class="fa-brands fa-facebook-f"></i>
                                                </a>
                                            </li>

                                            {{-- Twitter (X) --}}
                                            <li>
                                                <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ urlencode($blog->title) }}"
                                                    target="_blank" title="X'te Paylaş">
                                                    <i class="fa-brands fa-x-twitter"></i>
                                                </a>
                                            </li>

                                            {{-- LinkedIn --}}
                                            <li>
                                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title={{ urlencode($blog->title) }}"
                                                    target="_blank" title="LinkedIn'de Paylaş">
                                                    <i class="fa-brands fa-linkedin-in"></i>
                                                </a>
                                            </li>

                                            {{-- WhatsApp --}}
                                            <li>
                                                <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title) }} - {{ url()->current() }}"
                                                    target="_blank" title="WhatsApp'ta Paylaş">
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