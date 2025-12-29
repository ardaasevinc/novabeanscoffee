@if($whyChoose)
    <div class="why-choose-us light-bg-section">
        <div class="container">
            <div class="row">
                {{-- SOL KOLON: Başlık ve Buton --}}
                <div class="col-lg-6">
                    <div class="why-choose-content">
                        <div class="section-title">
                            @if($whyChoose->sub_title)
                                <h3 class="wow fadeInUp">{{ $whyChoose->sub_title }}</h3>
                            @endif
                            
                            <h2 class="text-anime-style-3" data-cursor="-opaque">
                                {{ $whyChoose->main_title }}
                            </h2>
                        </div>

                        @if($whyChoose->btn_text && $whyChoose->btn_url && Route::has($whyChoose->btn_url))
                            <div class="why-choose-btn wow fadeInUp" data-wow-delay="0.2s">
                                <a href="{{ route($whyChoose->btn_url) }}" class="btn-default">
                                    {{ $whyChoose->btn_text }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- SAĞ KOLON: Maddeler Listesi --}}
                <div class="col-lg-6">
                    <div class="why-choose-list wow fadeInUp" data-wow-delay="0.2s">
                        
                        @if(!empty($whyChoose->items))
                            @foreach($whyChoose->items as $item)
                                <div class="why-choose-item">
                                    <div class="icon-box">
                                        {{-- İkon Uploads klasöründen çekiliyor --}}
                                        <img src="{{ asset('uploads/' . $item['icon']) }}" 
                                             alt="{{ $item['title'] ?? 'İkon' }}">
                                    </div>
                                    <div class="why-choose-item-content">
                                        <h3>{{ $item['title'] }}</h3>
                                        {{-- Açıklama RichEditor olduğu için {!! !!} kullandık --}}
                                        <div style="color: #636363;">
                                            {!! $item['desc'] !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endif