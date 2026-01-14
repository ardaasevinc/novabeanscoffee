<div class="nova-feedback-wrapper" 
     x-data="{ 
        open: @entangle('showForm'), 
        visible: !localStorage.getItem('nova_feedback_seen'), 
        submitted: @entangle('submitted'),
        hideForever() {
            this.visible = false;
            localStorage.setItem('nova_feedback_seen', 'true');
        }
     }" 
     x-init="$watch('submitted', value => { if (value) setTimeout(() => hideForever(), 4000) })"
     x-show="visible" 
     x-cloak 
     x-transition:leave="transition ease-in duration-300 transform"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95">

    <style>
        [x-cloak] { display: none !important; }

        .nova-feedback-wrapper {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 340px;
            z-index: 99999;
            font-family: 'Jost', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        
        .nova-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 140%;
            height: 140%;
            background: radial-gradient(circle, rgba(201, 165, 129, 0.08) 0%, rgba(18, 29, 35, 0) 70%);
            filter: blur(60px);
            z-index: -1;
            pointer-events: none;
        }

        .nova-card {
            background: rgba(18, 29, 35, 0.55);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            position: relative;
            padding: 24px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 60px -12px rgba(0, 0, 0, 0.8);
        }

        .nova-header { display: flex; align-items: center; justify-content: space-between; }
        
        .nova-main-title { 
            color: #ffffff; 
            font-weight: 900; 
            font-size: 14px; 
            letter-spacing: 1.5px; 
            text-transform: uppercase;
            margin: 0;
            line-height: 1;
        }

        .nova-brand-motto { 
            color: #C9A581; 
            font-size: 9px; 
            font-weight: 700; 
            text-transform: uppercase; 
            letter-spacing: 2px;
            margin-top: 5px;
            opacity: 0.8;
        }

        .nova-success-info {
            color: rgba(201, 165, 129, 0.9);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.5px;
            line-height: 1.5;
            margin: 12px 0 18px;
        }

        .emoji-group { display: flex; gap: 10px; align-items: center; }
        .emoji-sm {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(201, 165, 129, 0.1);
            font-size: 20px;
            padding: 8px 12px;
            border-radius: 16px;
            cursor: pointer;
            transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .emoji-sm.active { background: rgba(201, 165, 129, 0.2); border-color: #E4CCB4; transform: scale(1.1); }

        .nova-input-sm {
            width: 100%;
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(201, 165, 129, 0.15);
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 12px;
            font-size: 12px;
            color: #fff;
            outline: none;
            transition: 0.3s;
        }
        .nova-input-sm::placeholder { color: #C9A581; font-weight: 600; letter-spacing: 0.5px; }
        .nova-input-sm:focus { border-color: #C9A581; background: rgba(0, 0, 0, 0.4); }

        .input-container { position: relative; width: 100%; }
        .nova-textarea {
            width: 100%;
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(201, 165, 129, 0.15);
            border-radius: 14px;
            padding: 14px 45px 14px 14px;
            font-size: 12px;
            color: #fff;
            outline: none;
            resize: none;
            overflow: hidden;
            min-height: 54px;
            transition: 0.3s;
        }
        .nova-textarea:focus { border-color: #C9A581; background: rgba(0, 0, 0, 0.4); }

        .send-icon-btn {
            position: absolute;
            right: 10px;
            bottom: 10px;
            background: transparent;
            color: #C9A581;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s ease;
        }
        .send-icon-btn:hover { transform: translateY(-2px); }

        .form-area {
            max-height: 0;
            overflow: hidden;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .form-area.show { max-height: 500px; margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.03); }

        .close-btn {
            position: absolute;
            top: 16px;
            right: 16px;
            background: rgba(255, 255, 255, 0.02);
            border: none;
            color: rgba(201, 165, 129, 0.3);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }
        .close-btn:hover { color: #E4CCB4; background: rgba(255, 255, 255, 0.05); }

        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="nova-glow"></div>

    <div class="nova-card">
        <button class="close-btn" @click="hideForever()">&times;</button>

        @if($submitted)
            <div style="text-align: center; padding: 10px 5px;">
                <div style="font-size: 32px; margin-bottom: 10px; filter: drop-shadow(0 0 10px rgba(201,165,129,0.3));">✨</div>
                <h4 class="nova-main-title" style="font-size: 16px;">Geri Bildirim Alındı</h4>
                <div class="nova-success-info">Nova Beans Coffee olarak görüşlerinize önem veriyoruz. Bizi Google'da da desteklemek ister misiniz?</div>
                <button onclick="window.open('https://search.google.com/local/writereview?placeid=ChIJ2XQJRRFFtRQRkrkiae-a4hk', '_blank')" 
                        style="background: #E4CCB4; color: #121D23; border: none; padding: 14px 24px; border-radius: 12px; font-weight: 800; font-size: 11px; cursor: pointer; letter-spacing: 1px; text-transform: uppercase; width: 100%;">
                    Google'da Yorum Yap
                </button>
            </div>
        @else
            <div class="nova-header">
                <div>
                    <h3 class="nova-main-title">Sevdiniz mi?</h3>
                    <div class="nova-brand-motto">Nova Beans Experience</div>
                </div>
                <div class="emoji-group">
                    <button wire:click="setLike(true)" class="emoji-sm {{ $is_liked === true ? 'active' : '' }}">👍</button>
                    <button wire:click="setLike(false)" @click="hideForever()" class="emoji-sm {{ $is_liked === false ? 'active' : '' }}" style="filter: {{ $is_liked === false ? 'grayscale(0)' : 'grayscale(1)' }}">👎</button>
                </div>
            </div>

            <div class="form-area" :class="open ? 'show' : ''">
                <input type="text" wire:model.defer="user_name" placeholder="Adın" class="nova-input-sm">
                
                <div class="input-container">
                    <textarea 
                        wire:model.defer="user_comment" 
                        placeholder="Deneyiminizi buraya yazın..." 
                        rows="1" 
                        x-data="{ resize() { $el.style.height = '0px'; $el.style.height = $el.scrollHeight + 'px' } }"
                        x-init="resize()"
                        @input="resize()"
                        class="nova-textarea scrollbar-hide"
                    ></textarea>

                    <button wire:click="submitFeedback" class="send-icon-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>