@extends('layouts.site')

@section('content')
@include('site.components.page-header')

<div class="page-service-single">
    <div class="container">
        <div class="row">
            
            {{-- SOL SIDEBAR --}}
            <div class="col-lg-4">
                <div class="page-single-sidebar">
                    
                    {{-- Hizmet Listesi --}}
                    <div class="page-category-list wow fadeInUp">
                        <h3>Hizmetlerimiz</h3>
                        <ul>
                            @foreach($allServices as $item)
                                <li>
                                    {{-- Aktif olan hizmete class ekliyoruz --}}
                                    <a href="{{ route('site.services.detail', $item->slug) }}" 
                                       class="{{ $item->id === $service->id ? 'active' : '' }}">
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- İletişim Kutusu (CTA) --}}
                    <div class="sidebar-cta-box wow fadeInUp" data-wow-delay="0.25s">
                        <div class="cta-client-images">
                             {{-- Buradaki resimler statik kalabilir veya random user çekilebilir --}}
                            <div class="cta-client-img">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets/images/satisfy-client-img-1.jpg') }}" alt="">
                                </figure>
                            </div>
                            <div class="cta-client-img">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets/images/satisfy-client-img-2.jpg') }}" alt="">
                                </figure>
                            </div>
                            <div class="cta-client-img">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets/images/satisfy-client-img-3.jpg') }}" alt="">
                                </figure>
                            </div>
                        </div>

                        <div class="sidebar-cta-body">
                            <h3>Sorunuz mu var?</h3>
                            <p>Size yardımcı olmaktan mutluluk duyarız. Lütfen bizimle <a href="{{ route('site.contact') }}">iletişime geçin</a>.</p>
                        </div>

                        @if(isset($setting))
                        <div class="sidebar-cta-footer">
                            <ul>
                                @if($setting->phone)
                                    <li>
                                        <a href="tel:{{ str_replace(' ', '', $setting->phone) }}">
                                            <img src="{{ asset('assets/images/icon-phone.svg') }}" alt=""> {{ $setting->phone }}
                                        </a>
                                    </li>
                                @endif
                                @if($setting->email)
                                    <li>
                                        <a href="mailto:{{ $setting->email }}">
                                            <img src="{{ asset('assets/images/icon-mail.svg') }}" alt=""> {{ $setting->email }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- SAĞ İÇERİK ALANI --}}
            <div class="col-lg-8">
                <div class="service-single-content">
                    
                    {{-- Hizmet Görseli --}}
                    <div class="service-feature-image">
                        <figure class="image-anime reveal">
                            @if($service->icon)
                                {{-- Service Resource'da 'icon' olarak tanımlamıştık, burada büyük görsel olarak kullanıyoruz --}}
                                <img src="{{ asset('uploads/' . $service->icon) }}" alt="{{ $service->title }}" style="width: 100%; border-radius: 20px;">
                            @else
                                <img src="{{ asset('assets/images/service-single-img.jpg') }}" alt="Varsayılan Görsel">
                            @endif
                        </figure>
                    </div>

                    {{-- Hizmet İçeriği (Rich Text) --}}
                    <div class="service-entry">
                        {{-- Admin panelinden girilen içerik buraya basılır --}}
                        <div class="wow fadeInUp">
                            {!! $service->desc !!}
                        </div>
                    </div>

                    {{-- 
                        NOT: Aşağıdaki FAQ (Sıkça Sorulan Sorular) kısmı statiktir. 
                        Veritabanında "Hizmet SSS" yapısı olmadığı için burayı sabit bıraktım.
                        İsterseniz admin panelinden RichEditor içine de SSS ekleyebilirsiniz.
                    --}}
                    
                    @if($faqs->count()>0)
                    
                <div class="faqs-content">
                    <div class="section-title">
                        <h3 class="wow fadeInUp">Sıkça Sorulan Sorular</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">NovaKitchen Hakkında <br>Merak Edilenler
                        </h2>
                    </div>

                    <div class="faq-accordion" id="accordion">
                        @if($faqs->count() > 0)
                            @foreach($faqs as $faq)
                                <div class="accordion-item wow fadeInUp" data-wow-delay="{{ 0.2 + ($loop->index * 0.2) }}s">
                                    <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                        {{--
                                        Mantık: İlk eleman ($loop->first) ise buton normal, değilse 'collapsed' sınıfı alır.
                                        aria-expanded: İlk eleman true, diğerleri false.
                                        --}}
                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}"
                                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                            aria-controls="collapse{{ $faq->id }}">
                                            {{ $faq->question }}
                                        </button>
                                    </h2>

                                    {{--
                                    Mantık: İlk eleman ($loop->first) ise 'show' sınıfı alır ve açık gelir.
                                    --}}
                                    <div id="collapse{{ $faq->id }}"
                                        class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                        aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            {{-- Rich Text İçerik --}}
                                            {!! $faq->answer !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info wow fadeInUp">
                                Henüz soru eklenmemiş.
                            </div>
                        @endif
                    </div>
                </div>
            
            @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection