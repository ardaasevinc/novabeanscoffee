@if($menuCategories->count() > 0)
    <div class="our-pricing">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h3 class="wow fadeInUp">Menümüz</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Lezzet dolu anların keyfini çıkarın</h2>
                    </div>
                    </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="our-pricing-box tab-content" id="pricingtab">
                        
                        <div class="our-support-nav wow fadeInUp" data-wow-delay="0.2s">
                            <ul class="nav nav-tabs" id="mvTab" role="tablist">
                                @foreach($menuCategories as $category)
                                    <li class="nav-item" role="presentation">
                                        {{-- İlk elemana 'active' sınıfı veriyoruz --}}
                                        <button class="btn-default btn-highlighted {{ $loop->first ? 'active' : '' }}" 
                                                id="{{ $category->slug }}-tab" 
                                                data-bs-toggle="tab"
                                                data-bs-target="#{{ $category->slug }}" 
                                                type="button" 
                                                role="tab" 
                                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                            {{ $category->title }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @foreach($menuCategories as $category)
                            <div class="pricing-boxes tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                 id="{{ $category->slug }}" 
                                 role="tabpanel">
                                
                                <div class="row align-items-center">
                                    {{-- SOL: Kategori Görseli --}}
                                    <div class="col-lg-6">
                                        <div class="pricing-image">
                                            <figure class="image-anime">
                                                @if($category->img)
                                                    <img src="{{ asset('uploads/' . $category->img) }}" alt="{{ $category->title }}" style="width: 100%; height: auto; border-radius: 20px;">
                                                @else
                                                    <img src="{{ asset('assets/images/pricing-tab-image-1.jpg') }}" alt="Varsayılan">
                                                @endif
                                            </figure>
                                        </div>
                                    </div>

                                    {{-- SAĞ: Ürün Listesi (Son 5) --}}
                                    <div class="col-lg-6">
                                        <div class="our-menu-list">
                                            @if($category->home_menus->isNotEmpty())
                                                @foreach($category->home_menus as $menu)
                                                    <div class="menu-list-item">
                                                        <div class="menu-list-image">
                                                            <figure>
                                                                <img src="{{ asset('uploads/' . $menu->img) }}" 
                                                                     alt="{{ $menu->title }}" 
                                                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                                                            </figure>
                                                        </div>

                                                        <div class="menu-item-body">
                                                            <div class="menu-item-title">
                                                                <h3>{{ $menu->title }}</h3>
                                                                <hr>
                                                                <span>{{ $menu->price }} ₺</span>
                                                            </div>
                                                            <div class="menu-item-content">
                                                                {{-- Açıklamayı düz metin olarak ve kısa haliyle basıyoruz --}}
                                                                <div style="color: #636363; font-size: 14px;">
                                                                    {!! Str::limit(strip_tags($menu->desc), 100) !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="alert alert-warning">
                                                    Bu kategoride henüz ürün bulunmuyor.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="section-footer-text wow fadeInUp" data-wow-delay="0.2s">
                            <p>Daha fazla seçenek mi arıyorsunuz? <a href="{{ route('site.menu') }}">Tüm menüyü incelemek için tıklayın!</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif