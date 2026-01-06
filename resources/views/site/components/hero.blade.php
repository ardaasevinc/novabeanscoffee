@if($heroes->count() > 0)
    @foreach($heroes as $item)
        <div class="hero hero-video">
            <div class="hero-bg-video">
                @if(!empty($item->video_url))
                    {{-- Video Varsa (TextInput olduğu için direkt URL basılır) --}}
                    <video autoplay muted loop playsinline id="heroVideo{{ $loop->index }}">
                        <source src="{{ $item->video_url }}" type="video/mp4">
                    </video>
                @elseif(!empty($item->image))
                    {{-- Video Yoksa Resim (Uploads klasöründen) --}}
                    <img src="{{ asset('uploads/' . $item->image) }}" 
                         alt="{{ $item->title }}" 
                         style="width: 100%; height: 100%; object-fit: cover; opacity: 0.6;">
                @endif
            </div>

            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="hero-content">
                            <div class="section-title">
                                @if($item->sub_title)
                                    <h3 class="wow fadeInUp">{{ $item->sub_title }}</h3>
                                @endif
                                
                                <h1 class="text-anime-style-3" data-cursor="-opaque">
                                    {{ $item->title }}
                                </h1>
                                
                                @if($item->desc)
                                    <div class="wow fadeInUp mt-3 text-white" data-wow-delay="0.2s">
                                        {!! $item->desc !!}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="hero-btn wow fadeInUp" data-wow-delay="0.4s">
                                {{-- Sol Buton --}}
                                @if($item->left_btn && Route::has($item->left_btn))
                                    <a href="{{ route($item->left_btn) }}" class="btn-default">Menüyü İncele</a>
                                @endif

                                {{-- Sağ Buton --}}
                                @if($item->right_btn && Route::has($item->right_btn))
                                    <a href="{{ route($item->right_btn) }}" class="btn-default btn-highlighted">Bize Ulaşın</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif