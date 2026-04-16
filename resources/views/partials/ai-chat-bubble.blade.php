@php
    $isId        = app()->getLocale() === 'id';
    $siteName    = App\Models\Setting::get('site_name', 'GreenHaven');
    $productId   = $productId   ?? null;
    $productName = $productName ?? null;
    $aiRoute     = auth()->check() ? route('ai.chat') : route('ai.chat.guest');

    $greeting = $productName
        ? ($isId
            ? "Halo! Saya <strong>JEZY</strong>, asisten tanaman {$siteName}. Tanya apa saja tentang <strong>{$productName}</strong> — perawatan, penyiraman, pencahayaan, dan lainnya 🌱"
            : "Hi! I'm <strong>JEZY</strong>, {$siteName}'s plant assistant. Ask me anything about <strong>{$productName}</strong> — care, watering, lighting, and more 🌱")
        : ($isId
            ? "Halo! Saya <strong>JEZY</strong>, asisten tanaman {$siteName}. Ada yang bisa saya bantu tentang tanaman? 🌿"
            : "Hi! I'm <strong>JEZY</strong>, {$siteName}'s plant assistant. How can I help you with plants today? 🌿");

    $quickQuestions = $productName
        ? ($isId
            ? [
                ['icon' => '🌿', 'label' => 'Cara merawat',    'q' => "Bagaimana cara merawat {$productName}?"],
                ['icon' => '💧', 'label' => 'Frekuensi siram', 'q' => "Berapa sering menyiram {$productName}?"],
                ['icon' => '☀️', 'label' => 'Kebutuhan cahaya','q' => "Cahaya apa yang dibutuhkan {$productName}?"],
                ['icon' => '🐾', 'label' => 'Aman hewan?',     'q' => "Apakah {$productName} aman untuk hewan peliharaan?"],
              ]
            : [
                ['icon' => '🌿', 'label' => 'Care tips',       'q' => "How do I care for {$productName}?"],
                ['icon' => '💧', 'label' => 'Watering',        'q' => "How often should I water {$productName}?"],
                ['icon' => '☀️', 'label' => 'Light needs',     'q' => "What light does {$productName} need?"],
                ['icon' => '🐾', 'label' => 'Pet safe?',       'q' => "Is {$productName} safe for pets?"],
              ])
        : ($isId
            ? [
                ['icon' => '🌿', 'label' => 'Tips tanaman indoor', 'q' => 'Apa tanaman indoor yang mudah dirawat?'],
                ['icon' => '💧', 'label' => 'Tips penyiraman',     'q' => 'Bagaimana cara menyiram tanaman yang benar?'],
                ['icon' => '☀️', 'label' => 'Tanaman minim cahaya','q' => 'Tanaman apa yang cocok untuk ruangan minim cahaya?'],
              ]
            : [
                ['icon' => '🌿', 'label' => 'Easy indoor plants',  'q' => 'What are easy indoor plants for beginners?'],
                ['icon' => '💧', 'label' => 'Watering tips',       'q' => 'How do I know when to water my plants?'],
                ['icon' => '☀️', 'label' => 'Low light plants',    'q' => 'What plants grow well in low light?'],
              ]);
@endphp

{{-- ── Floating Bubble Button ─────────────────────────────────────────── --}}
<button id="ai-bubble-btn" aria-label="AI Plant Expert"
    style="position:fixed; bottom:28px; right:28px; z-index:9990;
           width:60px; height:60px; border-radius:50%; border:none; cursor:pointer;
           background:linear-gradient(135deg,#22c55e,#16a34a);
           box-shadow:0 8px 24px rgba(22,163,74,.45);
           display:flex; align-items:center; justify-content:center;
           transition:transform .2s, box-shadow .2s;"
    onmouseenter="this.style.transform='scale(1.1)'; this.style.boxShadow='0 12px 32px rgba(22,163,74,.55)'"
    onmouseleave="this.style.transform='scale(1)';   this.style.boxShadow='0 8px 24px rgba(22,163,74,.45)'"
    onclick="toggleAiChat()">
    <svg id="ai-bubble-icon-open" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 2a9 9 0 0 1 9 9c0 4.97-4.03 9-9 9a8.96 8.96 0 0 1-4.35-1.12L3 21l2.12-4.65A8.96 8.96 0 0 1 3 11a9 9 0 0 1 9-9z"/>
        <circle cx="8.5" cy="11" r="1" fill="white" stroke="none"/>
        <circle cx="12"  cy="11" r="1" fill="white" stroke="none"/>
        <circle cx="15.5" cy="11" r="1" fill="white" stroke="none"/>
    </svg>
    <svg id="ai-bubble-icon-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" style="display:none;">
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
    </svg>
    {{-- Pulse ring --}}
    <span style="position:absolute; inset:-4px; border-radius:50%; border:2px solid rgba(34,197,94,.5); animation:ai-pulse 2s infinite;"></span>
</button>

{{-- ── Chat Window ──────────────────────────────────────────────────────── --}}
<div id="ai-chat-window"
    style="position:fixed; bottom:100px; right:28px; z-index:9989;
           width:360px; max-width:calc(100vw - 40px);
           background:white; border-radius:20px;
           box-shadow:0 20px 60px rgba(0,0,0,.18);
           display:none; flex-direction:column; overflow:hidden;
           transform:translateY(16px) scale(.97); opacity:0;
           transition:transform .25s cubic-bezier(.34,1.56,.64,1), opacity .2s;">

    {{-- Header --}}
    <div style="background:linear-gradient(135deg,#22c55e,#16a34a); padding:16px 18px; display:flex; align-items:center; gap:12px;">
        <div style="width:38px; height:38px; background:rgba(255,255,255,.2); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0;">🌿</div>
        <div style="flex:1; min-width:0;">
            <div style="color:white; font-weight:700; font-size:15px;">JEZY</div>
            <div style="color:rgba(255,255,255,.8); font-size:12px; display:flex; align-items:center; gap:5px;">
                <span style="width:7px; height:7px; background:#86efac; border-radius:50%; display:inline-block;"></span>
                {{ $isId ? 'Online' : 'Online' }}
            </div>
        </div>
        <button onclick="toggleAiChat()" style="background:rgba(255,255,255,.15); border:none; color:white; width:30px; height:30px; border-radius:50%; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;">✕</button>
    </div>

    {{-- Messages --}}
    <div id="ai-messages"
        style="flex:1; overflow-y:auto; padding:16px; display:flex; flex-direction:column; gap:12px; min-height:220px; max-height:320px; background:#f8fafc;">
        {{-- Greeting --}}
        <div style="display:flex; gap:8px; align-items:flex-end;">
            <div style="width:28px; height:28px; background:linear-gradient(135deg,#22c55e,#16a34a); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; flex-shrink:0;">🌿</div>
            <div style="background:white; padding:10px 14px; border-radius:16px 16px 16px 4px; font-size:13.5px; color:#1e293b; line-height:1.6; max-width:85%; box-shadow:0 1px 4px rgba(0,0,0,.06);">
                {!! $greeting !!}
            </div>
        </div>
    </div>

    {{-- Quick questions --}}
    <div id="ai-quick-wrap" style="padding:10px 14px 0; display:flex; flex-wrap:wrap; gap:6px; background:#f8fafc;">
        @foreach($quickQuestions as $q)
        <button class="ai-qbtn" data-q="{{ $q['q'] }}"
            style="padding:5px 12px; border-radius:20px; border:1.5px solid #bbf7d0; background:white;
                   color:#166534; font-size:12px; cursor:pointer; font-family:inherit; transition:all .15s;
                   display:flex; align-items:center; gap:4px;">
            {{ $q['icon'] }} {{ $q['label'] }}
        </button>
        @endforeach
    </div>

    {{-- Input --}}
    <div style="padding:12px 14px; background:white; border-top:1px solid #f1f5f9; display:flex; gap:8px; align-items:center;">
        <input id="ai-msg-input" type="text"
            placeholder="{{ $isId ? 'Tanya tentang tanaman...' : 'Ask about plants...' }}"
            style="flex:1; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:12px; font-size:13.5px;
                   outline:none; font-family:inherit; transition:border-color .15s;"
            onfocus="this.style.borderColor='#22c55e'"
            onblur="this.style.borderColor='#e2e8f0'"
            onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendAiBubble()}">
        <button id="ai-send-btn" onclick="sendAiBubble()"
            style="width:38px; height:38px; border-radius:50%; background:linear-gradient(135deg,#22c55e,#16a34a);
                   border:none; cursor:pointer; display:flex; align-items:center; justify-content:center;
                   flex-shrink:0; transition:opacity .15s;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
        </button>
    </div>
</div>

<style>
@keyframes ai-pulse {
    0%   { transform: scale(1);   opacity: .7; }
    70%  { transform: scale(1.4); opacity: 0;  }
    100% { transform: scale(1.4); opacity: 0;  }
}
.ai-qbtn:hover { background:#f0fdf4 !important; border-color:#4ade80 !important; }
#ai-messages::-webkit-scrollbar { width:4px; }
#ai-messages::-webkit-scrollbar-track { background:transparent; }
#ai-messages::-webkit-scrollbar-thumb { background:#d1fae5; border-radius:4px; }
</style>

<script>
(function () {
    const PRODUCT_ID  = {{ $productId ?? 'null' }};
    const CSRF        = window.Laravel?.csrfToken || document.querySelector('meta[name="csrf-token"]')?.content;
    const AI_ROUTE    = '{{ $aiRoute }}';
    const IS_ID       = {{ $isId ? 'true' : 'false' }};

    let isOpen = false;

    window.toggleAiChat = function () {
        isOpen = !isOpen;
        const win  = document.getElementById('ai-chat-window');
        const ico1 = document.getElementById('ai-bubble-icon-open');
        const ico2 = document.getElementById('ai-bubble-icon-close');

        if (isOpen) {
            win.style.display = 'flex';
            requestAnimationFrame(() => {
                win.style.transform = 'translateY(0) scale(1)';
                win.style.opacity   = '1';
            });
            ico1.style.display = 'none';
            ico2.style.display = 'block';
            document.getElementById('ai-msg-input').focus();
        } else {
            win.style.transform = 'translateY(16px) scale(.97)';
            win.style.opacity   = '0';
            setTimeout(() => { win.style.display = 'none'; }, 220);
            ico1.style.display = 'flex';
            ico2.style.display = 'none';
        }
    };

    function appendMsg(role, html) {
        const box = document.getElementById('ai-messages');
        const isBot = role === 'bot';
        const div = document.createElement('div');
        div.style.cssText = `display:flex; gap:8px; align-items:flex-end; ${isBot ? '' : 'flex-direction:row-reverse;'}`;
        div.innerHTML = isBot
            ? `<div style="width:28px;height:28px;background:linear-gradient(135deg,#22c55e,#16a34a);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">🌿</div>
               <div style="background:white;padding:10px 14px;border-radius:16px 16px 16px 4px;font-size:13.5px;color:#1e293b;line-height:1.6;max-width:85%;box-shadow:0 1px 4px rgba(0,0,0,.06);">${html}</div>`
            : `<div style="background:linear-gradient(135deg,#22c55e,#16a34a);padding:10px 14px;border-radius:16px 16px 4px 16px;font-size:13.5px;color:white;line-height:1.6;max-width:85%;">${html}</div>`;
        box.appendChild(div);
        box.scrollTop = box.scrollHeight;
    }

    function appendTyping() {
        const box = document.getElementById('ai-messages');
        const div = document.createElement('div');
        div.id = 'ai-typing';
        div.style.cssText = 'display:flex; gap:8px; align-items:flex-end;';
        div.innerHTML = `<div style="width:28px;height:28px;background:linear-gradient(135deg,#22c55e,#16a34a);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">🌿</div>
            <div style="background:white;padding:12px 16px;border-radius:16px 16px 16px 4px;box-shadow:0 1px 4px rgba(0,0,0,.06);display:flex;gap:4px;align-items:center;">
                <span style="width:7px;height:7px;background:#22c55e;border-radius:50%;animation:ai-dot 1.2s .0s infinite;display:inline-block;"></span>
                <span style="width:7px;height:7px;background:#22c55e;border-radius:50%;animation:ai-dot 1.2s .2s infinite;display:inline-block;"></span>
                <span style="width:7px;height:7px;background:#22c55e;border-radius:50%;animation:ai-dot 1.2s .4s infinite;display:inline-block;"></span>
            </div>`;
        box.appendChild(div);
        box.scrollTop = box.scrollHeight;
    }

    // Add dot animation style once
    const s = document.createElement('style');
    s.textContent = '@keyframes ai-dot{0%,80%,100%{transform:scale(.6);opacity:.4}40%{transform:scale(1);opacity:1}}';
    document.head.appendChild(s);

    window.sendAiBubble = async function (msg) {
        const input   = document.getElementById('ai-msg-input');
        const sendBtn = document.getElementById('ai-send-btn');
        const message = msg || input.value.trim();
        if (!message) return;

        // Hide quick buttons after first message
        const qwrap = document.getElementById('ai-quick-wrap');
        if (qwrap) qwrap.style.display = 'none';

        appendMsg('user', message);
        input.value = '';
        sendBtn.disabled = true;
        sendBtn.style.opacity = '.5';
        appendTyping();

        try {
            const res = await fetch(AI_ROUTE, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ message, product_id: PRODUCT_ID }),
            });
            const data = await res.json();
            document.getElementById('ai-typing')?.remove();
            appendMsg('bot', (data.reply || (IS_ID ? 'Maaf, tidak ada respons.' : 'Sorry, no response.')).replace(/\n/g, '<br>'));
        } catch {
            document.getElementById('ai-typing')?.remove();
            appendMsg('bot', IS_ID ? 'Maaf, terjadi kesalahan. Coba lagi ya! 🙏' : 'Sorry, something went wrong. Please try again! 🙏');
        } finally {
            sendBtn.disabled = false;
            sendBtn.style.opacity = '1';
        }
    };

    // Quick question buttons
    document.querySelectorAll('.ai-qbtn').forEach(btn => {
        btn.addEventListener('click', () => window.sendAiBubble(btn.dataset.q));
    });
})();
</script>
