@if($faqs->count()>0)
<div class="our-faqs">
    <div class="container">
        <div class="row align-items-center">
            {{-- SOL KOLON: Sıkça Sorulan Sorular --}}
            <div class="col-lg-6">
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
            </div>

            {{-- SAĞ KOLON: Görsel --}}
            <div class="col-lg-6">
                <div class="faqs-image">
                    <figure class="image-anime">
                        {{-- Buradaki görseli sabit bıraktım, istersen Setting modelinden çekebiliriz --}}
                        <img src="{{ asset('assets/images/524x638.webp') }}" alt="NovaKitchen Restaurant">
                    </figure>
                </div>
            </div>
        </div>
    </div>
</div>
@endif