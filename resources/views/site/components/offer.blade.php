@if($offers->count()>0)
<div class="our-offers">
    <div class="container">
        <div class="row align-items-center">
            
            {{-- SOL TARAFI: İçerik ve Akordiyon --}}
            <div class="col-lg-5">
                <div class="our-offers-content">
                    {{-- Sabit Başlık Alanı --}}
                    <div class="section-title">
                        <h3 class="wow fadeInUp">Neler Sunuyoruz?</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Özel davetlerinize şıklık katın</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">Özel etkinlikleriniz için sıcak ve davetkar bir atmosfer sunuyoruz. İster
                            doğum günü kutlaması, ister samimi bir toplanma veya özel bir iş yemeği olsun, anılarınızı güzelleştirmek için
                            buradayız.</p>
                    </div>

                    {{-- Dinamik Akordiyon Alanı --}}
                    <div class="offers-accordion" id="offer-accordion">
                        
                        @if($offers->count() > 0)
                            @foreach($offers as $offer)
                                {{-- Animasyon gecikmesi her maddede 0.2sn artar --}}
                                <div class="accordion-item wow fadeInUp" data-wow-delay="{{ 0.4 + ($loop->index * 0.2) }}s">
                                    <h2 class="accordion-header" id="offersheading{{ $offer->id }}">
                                        {{-- 
                                            Buton Mantığı:
                                            İlk eleman ($loop->first) ise normal, değilse 'collapsed' sınıfı alır.
                                        --}}
                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" 
                                                type="button" 
                                                data-bs-toggle="collapse"
                                                data-bs-target="#offerscollapse{{ $offer->id }}" 
                                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                aria-controls="offerscollapse{{ $offer->id }}">
                                            {{ $offer->title }}
                                        </button>
                                    </h2>
                                    
                                    {{-- 
                                        İçerik Mantığı:
                                        İlk eleman ($loop->first) ise 'show' sınıfı alır ve açık gelir.
                                    --}}
                                    <div id="offerscollapse{{ $offer->id }}" 
                                         class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                         aria-labelledby="offersheading{{ $offer->id }}" 
                                         data-bs-parent="#offer-accordion">
                                        <div class="accordion-body">
                                            <p>{{ $offer->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{-- Veri yoksa boş görünmesin diye isteğe bağlı uyarı --}}
                            <div class="alert alert-light wow fadeInUp" data-wow-delay="0.4s">
                                Hizmet detaylarımız yakında eklenecektir.
                            </div>
                        @endif

                    </div>

                    {{-- Buton: Rezervasyon sayfasına yönlendirir --}}
                    <div class="offer-button wow fadeInUp" data-wow-delay="1s">
                        <a href="{{ route('site.reservation') }}" class="btn-default">Etkinlik Planlayın</a>
                    </div>
                </div>
            </div>

            {{-- SAĞ TARAFI: Görseller (Sabit) --}}
            <div class="col-lg-7">
                <div class="our-offers-images">
                    <div class="offer-image">
                        <figure class="image-anime">
                            <img src="{{ asset('assets/images/offer-image.jpg') }}" alt="Nova Kitchen Etkinlik Alanı">
                        </figure>
                    </div>
                    <div class="offer-circle-image-1">
                        <figure class="image-anime">
                            <img src="{{ asset('assets/images/offer-circle-image-1.jpg') }}" alt="Lezzetli Sunumlar">
                        </figure>
                    </div>
                    <div class="offer-circle-image-2">
                        <figure class="image-anime">
                            <img src="{{ asset('assets/images/offer-circle-image-2.jpg') }}" alt="Özel Kokteyller">
                        </figure>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endif