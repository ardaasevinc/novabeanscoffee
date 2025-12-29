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
                                    <a href="{{ route('site.service.detail', $item->slug) }}" 
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
                    <div class="page-single-faqs mt-5">
                        <div class="section-title">
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Sıkça Sorulan Sorular</h2>
                        </div>

                        <div class="faq-accordion" id="faqaccordion">
                            <div class="accordion-item wow fadeInUp">
                                <h2 class="accordion-header" id="heading1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                        Bu hizmet için rezervasyon süreci nasıl?
                                    </button>
                                </h2>
                                <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#faqaccordion">
                                    <div class="accordion-body">
                                        <p>İletişim sayfamızdan veya telefon numaramızdan bize ulaşarak detaylı planlama yapabilirsiniz.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item wow fadeInUp" data-wow-delay="0.2s">
                                <h2 class="accordion-header" id="heading2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                        Fiyatlandırma nasıl yapılıyor?
                                    </button>
                                </h2>
                                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#faqaccordion">
                                    <div class="accordion-body">
                                        <p>Hizmetin kapsamına, kişi sayısına ve özel isteklere göre size özel teklif hazırlıyoruz.</p>
                                    </div>
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