@if ($blogCategories->count() > 3)
    <div class="interactive interactive-process-layout overflow-y-auto">
        <div class="interactive-interactive-process-wrapper interactive-wrapper">
            <div class="interactive-con">

                <div class="interactive-con-inner interactive-grid">
                    @foreach ($blogCategories as $category)
                        <div class="interactive-process-item">
                            {{-- İlk elemana 'activate' sınıfı veriyoruz, data-index döngüden geliyor (0, 1, 2...) --}}
                            <div class="interactive-inner-process {{ $loop->first ? 'activate' : '' }}"
                                data-index="{{ $loop->index }}">
                                <div class="process-content-wap">
                                    <div class="process-inner-content-wap">
                                        {{-- HTML taglerini temizleyip 30 karakter ile sınırlıyoruz --}}
                                        <p>{{ Str::limit(strip_tags($category->desc), 30) }}</p>

                                        <h2>
                                            <a href="{{ route('site.blog.category', $category->slug) }}">
                                                {{ $category->title }}
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="interactive-process-list-image">
                    @foreach ($blogCategories as $category)
                        {{-- Resimlerde img-0, img-1 gibi classlar olmalı. İlk resim 'show' alır --}}
                        <div class="interactive-process-image img-{{ $loop->index }} {{ $loop->first ? 'show' : '' }}"
                            data-bg="{{ asset('uploads/' . $category->img) }}"
                            style="background-image: url('{{ asset('uploads/' . $category->img) }}');">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

