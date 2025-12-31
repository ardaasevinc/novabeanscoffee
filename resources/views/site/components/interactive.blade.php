@if ($blogCategories->count() > 3)
    <style>
        /* Ana konteynırı yan yana dizilmeye ve kaydırmaya hazırla */
        .interactive-con-inner.interactive-grid {
            display: flex !important; /* Grid yerine Flex kullanarak yan yana dizilimi zorunlu kılıyoruz */
            flex-wrap: nowrap !important; /* Alt satıra geçmeyi engelliyoruz */
            overflow-x: auto !important; /* Yatayda kaydırmayı açıyoruz */
            overflow-y: hidden; 
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            gap: 0; /* Mevcut tasarımındaki boşlukları korumak için */
            padding-bottom: 5px;
        }

        /* Kartların genişliğini korumasını sağla, flex içinde daralmasını engelle */
        .interactive-process-item {
            flex: 0 0 25%; /* Ekranın 1/4'ünü kaplamasını sağlar (4 tane yan yana) */
            min-width: 280px; /* Mobilde çok küçülmemesi için sınır */
        }

        /* Tasarımı bozmaması için scrollbar'ı gizle (isteğe bağlı) */
        .interactive-con-inner.interactive-grid::-webkit-scrollbar {
            display: none;
        }
        .interactive-con-inner.interactive-grid {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>

    <div class="interactive interactive-process-layout">
        <div class="interactive-interactive-process-wrapper interactive-wrapper">
            <div class="interactive-con">
                {{-- Kaydırılabilir Liste Alanı --}}
                <div class="interactive-con-inner interactive-grid">
                    @foreach ($blogCategories as $category)
                        <div class="interactive-process-item">
                            <div class="interactive-inner-process {{ $loop->first ? 'activate' : '' }}"
                                data-index="{{ $loop->index }}">
                                <div class="process-content-wap">
                                    <div class="process-inner-content-wap">
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

                {{-- Arkaplan Resim Alanı (Mevcut mantık değişmedi) --}}
                <div class="interactive-process-list-image">
                    @foreach ($blogCategories as $category)
                        <div class="interactive-process-image img-{{ $loop->index }} {{ $loop->first ? 'show' : '' }}"
                            data-bg="{{ asset('uploads/' . $category->img) }}"
                            style="background-image: url('{{ asset('uploads/' . $category->img) }}');">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif