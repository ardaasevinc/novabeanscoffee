@if($about)
    <div class="about-us">
        <div class="container">
            <div class="row align-items-center">
                {{-- SOL KOLON: İçerik --}}
                <div class="col-lg-6">
                    <div class="about-us-content">
                        <div class="section-title">
                            @if($about->sub_title)
                                <h3 class="wow fadeInUp">{{ $about->sub_title }}</h3>
                            @endif

                            <h2 class="text-anime-style-3" data-cursor="-opaque">
                                {{ $about->main_title }}
                            </h2>
                        </div>

                        {{-- Foreach ile Özellik Listesi --}}
                        @if(!empty($about->features) && is_array($about->features))
                            <div class="about-body-list">
                                @foreach($about->features as $item)
                                    {{-- Animasyon gecikmesini sırayla arttırıyoruz --}}
                                    <div class="about-body-item wow fadeInUp" data-wow-delay="{{ 0.2 + ($loop->index * 0.2) }}s">
                                        <div class="icon-box">
                                            {{-- DÜZELTME: Uploads klasöründen çekiyoruz --}}
                                            <img src="{{ asset('uploads/' . $item['icon']) }}" alt="{{ $item['title'] ?? 'İkon' }}">
                                        </div>
                                        <div class="about-body-list-content">
                                            <h3>{{ $item['title'] }}</h3>
                                            <p>{!! $item['desc'] !!}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="about-us-footer wow fadeInUp" data-wow-delay="0.6s">
                            <div class="about-btn">
                                <a href="{{ route('site.about') }}" class="btn-default">Daha fazlası</a>
                            </div>

                            {{-- Video linki eğer veritabanında varsa oradan çekilebilir, yoksa statik kalır --}}
                            <div class="video-play-button">
                                <a href="https://www.youtube.com/watch?v=Y-x0efG1seA" class="popup-video"
                                    data-cursor-text="Oynat">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                                <p>Videoyu İzle</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SAĞ KOLON: Görsel ve Saatler --}}
                <div class="col-lg-6">
                    <div class="about-us-image">
                        <div class="about-us-img">
                            <figure class="image-anime">
                                {{-- DÜZELTME: Ana resim varsa uploads'tan, yoksa assets'ten çek --}}
                                @if(!empty($about->img))
                                    <img src="{{ asset('uploads/' . $about->img) }}" alt="{{ $about->main_title }}">
                                @else
                                    <img src="{{ asset('assets/images/about-us-image.jpg') }}" alt="Hakkımızda Görseli">
                                @endif
                            </figure>
                        </div>

                        {{-- Çalışma Saatleri --}}
                        <div class="opening-time-box">
                            <div class="icon-box">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div class="opening-time-content">
                                <h3>Çalışma Saatleri</h3>
                                <ul>
                                    <li>Pazartesi - Cuma<span>09:30 - 02:00</span></li>
                                    <li>Mutfak Kapanış<span>23.00</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif