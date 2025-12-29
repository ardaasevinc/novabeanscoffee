<div class="our-scrolling-ticker">
    <div class="scrolling-ticker-box">
        <div class="scrolling-content">
            
            @if(isset($tickerItems) && $tickerItems->count() > 0)
                {{-- 1. DÖNGÜ: Verileri basıyoruz --}}
                @foreach($tickerItems as $item)
                    <span>
                        <img src="{{ asset('assets/images/asterisk-icon.svg') }}" alt="*">
                        {{ $item->title }}
                    </span>
                @endforeach

                {{-- 2. DÖNGÜ (TEKRAR): Sonsuz döngü efekti kesilmesin diye verileri tekrar basıyoruz --}}
                @foreach($tickerItems as $item)
                    <span>
                        <img src="{{ asset('assets/images/asterisk-icon.svg') }}" alt="*">
                        {{ $item->title }}
                    </span>
                @endforeach
            @else
            
                <span><img src="assets/images/asterisk-icon.svg" alt="">Nova Kitchen Restaurant için ❤️ ile tasarlanmıştır.</span>
            @endif

        </div>
    </div>
    </div>