{{-- Sadece içinde en az bir ürün (home_menus) olan kategorileri filtrele --}}
@php
    $visibleCategories = $menuCategories->filter(function($category) {
        return $category->home_menus->isNotEmpty();
    });
@endphp

@if($visibleCategories->count() > 0)
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
                                @foreach($visibleCategories as $category)
                                    <li class="nav-item" role="presentation">
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

                        @foreach($visibleCategories as $category)
                            <div class="pricing-boxes tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                 id="{{ $category->slug }}" 
                                 role="tabpanel">
                                
                                <div class="row align-items-center">
                                    {{-- SOL: Kategori Görseli --}}
                                    <div class="col-lg-6">
                                        <div class="pricing-image">
                                            <figure class="image-anime">
                                                <img src="{{ $category->img ? asset('uploads/' . $category->img) : asset('no-blog-img.webp') }}" 
                                                     alt="{{ $category->title }}" 
                                                     style="width: 100%; height: auto; border-radius: 20px;">
                                            </figure>
                                        </div>
                                    </div>

                                    {{-- SAĞ: Ürün Listesi --}}
                                    <div class="col-lg-6">
                                        <div class="our-menu-list">
                                            @foreach($category->home_menus as $menu)
                                                <div class="menu-list-item">
                                                    <div class="menu-list-image">
                                                        <figure>
                                                            <img src="{{ $menu->img ? asset('uploads/' . $menu->img) : asset('assets/images/no-blog-img.webp') }}" 
                                                                 alt="{{ $menu->title }}" 
                                                                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                                                        </figure>
                                                    </div>

                                                    <div class="menu-item-body">
                                                        <div class="menu-item-title">
                                                            <h3>{{ $menu->title }}</h3>
                                                            <hr>
                                                            
                                                            {{-- FİYAT MANTIĞI --}}
                                                            <div class="menu-prices" style="display: flex; gap: 10px; font-weight: bold; color: #e4b95b;">
                                                                @if($menu->has_sizes)
                                                                    {{-- Boyutlu Ürün Fiyatları --}}
                                                                    @if($menu->price > 0) <span><small style="font-size: 10px; color: #636363;">S:</small> {{ number_format($menu->price, 0) }}₺</span> @endif
                                                                    @if($menu->price_medium > 0) <span><small style="font-size: 10px; color: #636363;">M:</small> {{ number_format($menu->price_medium, 0) }}₺</span> @endif
                                                                    @if($menu->price_large > 0) <span><small style="font-size: 10px; color: #636363;">L:</small> {{ number_format($menu->price_large, 0) }}₺</span> @endif
                                                                @else
                                                                    {{-- Standart Tek Fiyat --}}
                                                                    @if($menu->price > 0)
                                                                        <span>{{ number_format($menu->price, 0) }}₺</span>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="menu-item-content">
                                                            <div style="color: #636363; font-size: 14px;">
                                                                {!! Str::limit(strip_tags($menu->desc), 100) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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