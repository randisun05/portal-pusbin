<style>
    #pkChatToggle {
        position: fixed; bottom: 84px; right: 15px; width: 58px; height: 58px; border-radius: 50%;
        background: var(--accent-color, #b5261f); color: #fff; border: 0; box-shadow: 0 8px 20px rgba(181,38,31,.4);
        z-index: 1050; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; cursor: pointer;
        transition: transform .2s, box-shadow .2s;
    }
    #pkChatToggle:hover { transform: translateY(-2px) scale(1.05); box-shadow: 0 12px 24px rgba(181,38,31,.45); }
    #pkChatToggle .pk-chat-dot {
        position: absolute; top: 4px; right: 4px; width: 12px; height: 12px; border-radius: 50%;
        background: #2ecc71; border: 2px solid #fff;
    }
    #pkChatPanel {
        position: fixed; bottom: 152px; right: 15px; width: 340px; max-width: calc(100vw - 32px); height: 440px;
        background: #fff; border-radius: 16px; box-shadow: 0 12px 32px rgba(20,20,43,.2); z-index: 1050;
        display: flex; flex-direction: column; overflow: hidden;
    }
    #pkChatPanel.d-none { display: none !important; }
    #pkChatHeader { background: var(--accent-color, #b5261f); color: #fff; padding: 14px 16px; font-weight: 600; display: flex; justify-content: space-between; align-items: center; }
    #pkChatHeader .pk-chat-title { display: flex; align-items: center; gap: 10px; }
    #pkChatHeader .pk-chat-title i { font-size: 1.3rem; }
    #pkChatHeader button { background: none; border: 0; color: #fff; font-size: 1.1rem; cursor: pointer; }
    #pkChatBody { flex: 1; overflow-y: auto; padding: 14px; background: #f7f8fb; }
    .pk-chat-bubble { max-width: 85%; padding: 10px 14px; border-radius: 12px; margin-bottom: 10px; font-size: .88rem; line-height: 1.4; }
    .pk-chat-bot { background: #fdeceb; color: #22284a; border-bottom-left-radius: 2px; }
    .pk-chat-user { background: var(--accent-color, #b5261f); color: #fff; margin-left: auto; border-bottom-right-radius: 2px; }
    #pkChatForm { display: flex; border-top: 1px solid #eceff3; }
    #pkChatInput { flex: 1; border: 0; padding: 12px 14px; font-size: .88rem; }
    #pkChatInput:focus { outline: none; }
    #pkChatForm button { border: 0; background: var(--accent-color, #b5261f); color: #fff; padding: 0 18px; }
</style>

<button type="button" id="pkChatToggle" aria-label="Chat Bantuan"><i class="bi bi-chat-dots-fill"></i><span class="pk-chat-dot"></span></button>

<div id="pkChatPanel" class="d-none">
    <div id="pkChatHeader">
        <span class="pk-chat-title"><i class="bi bi-headset"></i>Bantuan Direktorat JF MASN</span>
        <button type="button" id="pkChatClose" aria-label="Tutup"><i class="bi bi-x-lg"></i></button>
    </div>
    <div id="pkChatBody">
        <div class="pk-chat-bubble pk-chat-bot">Halo! Ada yang bisa kami bantu? Silakan ketik pertanyaan Anda, atau lihat halaman <a href="/faq" target="_blank">FAQ</a> lengkap kami.</div>
    </div>
    <form id="pkChatForm">
        <input type="text" id="pkChatInput" placeholder="Tulis pertanyaan..." autocomplete="off">
        <button type="submit"><i class="bi bi-send-fill"></i></button>
    </form>
</div>

<script>
(function () {
    var faqData = @json($chatFaqs ?? []);
    var knowledgeData = @json($chatKnowledge ?? []);
    knowledgeData.forEach(function (item) {
        faqData.push({ pertanyaan: item.judul + (item.kata_kunci ? ' ' + item.kata_kunci : ''), jawaban: item.isi });
    });
    var toggle = document.getElementById('pkChatToggle');
    var panel = document.getElementById('pkChatPanel');
    var closeBtn = document.getElementById('pkChatClose');
    var body = document.getElementById('pkChatBody');
    var form = document.getElementById('pkChatForm');
    var input = document.getElementById('pkChatInput');

    function addBubble(text, who) {
        var div = document.createElement('div');
        div.className = 'pk-chat-bubble ' + (who === 'user' ? 'pk-chat-user' : 'pk-chat-bot');
        div.textContent = text;
        body.appendChild(div);
        body.scrollTop = body.scrollHeight;
    }

    function findAnswer(question) {
        var q = question.toLowerCase();
        var words = q.split(/\s+/).filter(function (w) { return w.length > 2; });
        var best = null;
        var bestScore = 0;

        faqData.forEach(function (faq) {
            var haystack = (faq.pertanyaan + ' ' + faq.jawaban).toLowerCase();
            var score = 0;
            words.forEach(function (w) {
                if (haystack.indexOf(w) !== -1) score++;
            });
            if (score > bestScore) {
                bestScore = score;
                best = faq;
            }
        });

        return bestScore > 0 ? best : null;
    }

    toggle.addEventListener('click', function () {
        panel.classList.toggle('d-none');
    });
    closeBtn.addEventListener('click', function () {
        panel.classList.add('d-none');
    });

    function fallbackAnswer(question) {
        var match = findAnswer(question);
        addBubble(match ? match.jawaban : 'Maaf, kami belum menemukan jawaban yang cocok. Silakan hubungi kami melalui halaman Kontak, atau lihat daftar FAQ lengkap.', 'bot');
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var question = input.value.trim();
        if (!question) return;
        addBubble(question, 'user');
        input.value = '';

        fetch('/chat/ask', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : ''
            },
            body: JSON.stringify({ question: question })
        }).then(function (res) {
            return res.ok ? res.json() : { answer: null };
        }).then(function (data) {
            if (data && data.answer) {
                addBubble(data.answer, 'bot');
            } else {
                fallbackAnswer(question);
            }
        }).catch(function () {
            fallbackAnswer(question);
        });
    });
})();
</script>
