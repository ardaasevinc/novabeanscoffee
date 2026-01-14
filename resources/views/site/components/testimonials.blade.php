@if(!empty($testimonials) && $testimonials->count() > 0)
<div class="our-testimonials parallaxie">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h3 class="wow fadeInUp">Sizden Gelenler</h3>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">Nova Beans Deneyimini Yaşayanlar</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="testimonial-slider">
                    <div class="swiper" wire:ignore x-data x-init="
                        new Swiper($el, {
                            slidesPerView: 1,
                            spaceBetween: 50, {{-- Slide'lar arası boşluğu artırdık --}}
                            loop: true,
                            autoHeight: true, {{-- Uzun yorumlara göre yükseklik ayarı --}}
                            autoplay: { delay: 5000, disableOnInteraction: false },
                            navigation: {
                                nextEl: '.testimonial-btn-next',
                                prevEl: '.testimonial-btn-prev',
                            },
                        })
                    ">
                        <div class="swiper-wrapper" data-cursor-text="Drag">
                            
                            @forelse($testimonials as $item)
                                <div class="swiper-slide" style="height: auto;">
                                    <div class="testimonial-item" style="display: flex; flex-direction: column; align-items: center; text-align: center; width: 100%; overflow: hidden;">
                                        <div class="testimonial-content" style="max-width: 800px; margin: 0 auto;">
                                            {{-- Metinlerin taşmaması için word-break ekledik --}}
                                            <p style="word-break: break-word; line-height: 1.6;">“ {{ Str::limit($item->user_comment, 80) }} ”</p>
                                        </div>
                                        <div class="author-info" style="margin-top: 20px;">
                                            <p style="text-transform: uppercase; letter-spacing: 2px; font-weight: 700; margin-bottom: 5px; word-break: break-all;">
                                                {{ $item->user_name }}
                                            </p>
                                            <span style="color: #C9A581; font-size: 11px; font-weight: 800; letter-spacing: 1.5px;">
                                                {{ $item->is_liked ? 'MUTLU MÜŞTERİ' : 'GERİ BİLDİRİM' }}
                                            </span>
                                        </div>                                    
                                    </div>
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <div class="testimonial-item" style="text-align: center;">
                                        <div class="testimonial-content">
                                            <p>“ Henüz onaylanmış bir yorum bulunmuyor. İlk yorumu siz yapın! ”</p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                                             
                        </div>
                        
                        <div class="testimonial-btn">
                            <div class="testimonial-btn-prev"></div>
                            <div class="testimonial-btn-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Üst üste binmeyi engellemek için kritik CSS */
    .testimonial-slider .swiper-slide {
        opacity: 0 !important;
        transition: opacity 0.5s ease;
        pointer-events: none;
    }
    .testimonial-slider .swiper-slide-active {
        opacity: 1 !important;
        pointer-events: auto;
    }
    .author-info p {
        margin-bottom: 0 !important; /* Alt taraftaki gereksiz boşlukları temizler */
    }
</style>
@endif