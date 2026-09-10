@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.partial.notif')

<main>
@include('layout.web.header-detail')

<style>
    .sv-progress-wrap { position: sticky; top: 0; z-index: 20; background: #fff; padding: 14px 0; border-bottom: 1px solid #eceff3; }
    .sv-progress-bar { height: 10px; border-radius: 20px; background: #eceff3; overflow: hidden; }
    .sv-progress-bar-fill { height: 100%; width: 0%; background: linear-gradient(90deg, #f92c24, #fd346e); transition: width .3s ease; }
    .sv-progress-label { font-size: .82rem; color: #6c7382; margin-top: 4px; display: flex; justify-content: space-between; }
    .sv-progress-label .sv-pct { font-weight: 700; color: #f92c24; }

    .sv-emoji-card { border: 1px solid #eceff3; border-radius: 16px; padding: 20px 22px; margin-bottom: 18px; background: #fff; box-shadow: 0 2px 12px rgba(20,23,43,.05); }
    .sv-emoji-question { font-weight: 700; margin-bottom: 16px; font-size: 1rem; }
    .sv-emoji-options { display: flex; flex-wrap: wrap; gap: 10px; }
    .sv-emoji-option { position: relative; flex: 1 1 0; min-width: 92px; display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 14px 8px; border-radius: 14px; border: 2px solid #eceff3; background: #f7f8fa; cursor: pointer; text-align: center; transition: transform .15s ease, border-color .15s ease, background-color .15s ease; }
    .sv-emoji-option input { position: absolute; opacity: 0; width: 100%; height: 100%; margin: 0; cursor: pointer; }
    .sv-emoji-option .sv-emoji { font-size: 2rem; line-height: 1; filter: grayscale(60%); opacity: .65; transition: filter .15s ease, opacity .15s ease; }
    .sv-emoji-option .sv-emoji-text { font-size: .72rem; color: #6c7382; font-weight: 700; }
    .sv-emoji-option:hover { transform: translateY(-2px); background: #eef0f4; }
    .sv-emoji-option.is-selected { border-color: var(--sv-color); background: var(--sv-bg); }
    .sv-emoji-option.is-selected .sv-emoji { filter: grayscale(0%); opacity: 1; transform: scale(1.15); }
    .sv-emoji-option.is-selected .sv-emoji-text { color: var(--sv-color); }
    @media (max-width: 576px) {
        .sv-emoji-option { min-width: 30%; }
        .sv-emoji-option .sv-emoji { font-size: 1.6rem; }
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2 py-5">

            @if($groups->isEmpty())

                <div class="text-center fw-bold mt-4">
                    Indikator Survei Belum Tersedia
                </div>
                <div class="text-center">
                    <a href="/survei" class="btn btn-primary mt-4">Kembali</a>
                </div>

            @else

                <div class="sv-progress-wrap">
                    <div class="sv-progress-bar"><div class="sv-progress-bar-fill" id="svProgressFill"></div></div>
                    <div class="sv-progress-label">
                        <span id="svProgressText">Ayo mulai isi survei!</span>
                        <span class="sv-pct" id="svProgressPct">0%</span>
                    </div>
                </div>

                <form action="/survei/{{ $survei->id }}" method="POST" id="svForm">
                    @csrf
                    @include('layout.partial.honeypot')

                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" id="nip" value="{{ old('nip') }}" required>
                        @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    @if($survei->type === 1)
                        <table class="table mt-4 align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Indikator</th>
                                    <th scope="col">Jawaban</th>
                                </tr>
                            </thead>
                            @foreach ($groups as $group)
                                <tr>
                                    <th scope="row">{{ $group->indikator->title }}</th>
                                    <td><input type="text" class="form-control" name="jawaban[{{ $group->indikator_id }}]" required></td>
                                </tr>
                            @endforeach
                        </table>

                    @elseif ($survei->type === 2)
                        <table class="table mt-4 align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Indikator</th>
                                    <th scope="col" class="text-center">Ya</th>
                                    <th scope="col" class="text-center">Tidak</th>
                                </tr>
                            </thead>
                            @foreach ($groups as $group)
                                <tr>
                                    <th scope="row">{{ $group->indikator->title }}</th>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="Ya" name="jawaban[{{ $group->indikator_id }}]" required></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="Tidak" name="jawaban[{{ $group->indikator_id }}]"></td>
                                </tr>
                            @endforeach
                        </table>

                    @elseif ($survei->type === 3 || $survei->type === 4)
                        @php
                            // Skala kepuasan interaktif berbasis emoji: tipe 3 = 3 titik,
                            // tipe 4 = 4 titik. Nilai yang dikirim tetap numerik (1..N)
                            // agar kompatibel dengan dashboard statistik & badge yang sudah ada.
                            $scale = $survei->type === 4
                                ? [
                                    1 => ['emoji' => '😠', 'label' => 'Tidak Memuaskan', 'color' => '#ff3e1d'],
                                    2 => ['emoji' => '😕', 'label' => 'Kurang Memuaskan', 'color' => '#ffab00'],
                                    3 => ['emoji' => '🙂', 'label' => 'Memuaskan', 'color' => '#03c3ec'],
                                    4 => ['emoji' => '😄', 'label' => 'Sangat Memuaskan', 'color' => '#71dd37'],
                                ]
                                : [
                                    1 => ['emoji' => '😞', 'label' => 'Tidak Memuaskan', 'color' => '#ff3e1d'],
                                    2 => ['emoji' => '😐', 'label' => 'Cukup Memuaskan', 'color' => '#ffab00'],
                                    3 => ['emoji' => '😄', 'label' => 'Sangat Memuaskan', 'color' => '#71dd37'],
                                ];
                        @endphp
                        <div class="mt-4">
                            @foreach ($groups as $group)
                                <div class="sv-emoji-card">
                                    <div class="sv-emoji-question">{{ $group->indikator->title }}</div>
                                    <div class="sv-emoji-options">
                                        @foreach ($scale as $nilai => $opt)
                                            <label class="sv-emoji-option" style="--sv-color: {{ $opt['color'] }}; --sv-bg: {{ $opt['color'] }}1a;">
                                                <input type="radio" value="{{ $nilai }}" name="jawaban[{{ $group->indikator_id }}]" {{ $loop->first ? 'required' : '' }}>
                                                <span class="sv-emoji">{{ $opt['emoji'] }}</span>
                                                <span class="sv-emoji-text">{{ $opt['label'] }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    @else
                        <table class="table mt-4 align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Indikator</th>
                                    <th scope="col">Jawaban</th>
                                </tr>
                            </thead>
                            @foreach ($groups as $group)
                                <tr>
                                    <th scope="row">{{ $group->indikator->title }}</th>
                                    <td><input type="text" class="form-control" name="jawaban[{{ $group->indikator_id }}]" required></td>
                                </tr>
                            @endforeach
                        </table>
                    @endif

                    <div class="col text-center m-3">
                        <button type="submit" class="btn btn-primary mb-3">Kirim Survei</button>
                        <a href="/survei" class="btn btn-secondary mb-3">Batal</a>
                    </div>
                </form>

            @endif

        </div>
    </div>
</div>
</main>

@include('layout.web.footer')

<script>
(function () {
    var form = document.getElementById('svForm');
    if (!form) return;

    var fill = document.getElementById('svProgressFill');
    var pctLabel = document.getElementById('svProgressPct');
    var textLabel = document.getElementById('svProgressText');
    var messages = ['Ayo mulai isi survei!', 'Lumayan, terus lanjutkan!', 'Sudah setengah jalan!', 'Sedikit lagi selesai!', 'Hampir sampai, semangat!', 'Survei siap dikirim!'];

    function requiredFields() {
        return Array.prototype.slice.call(form.querySelectorAll('[required]'));
    }

    function isFilled(field) {
        if (field.type === 'radio') {
            return form.querySelectorAll('input[name="' + field.name + '"]:checked').length > 0;
        }
        return field.value.trim() !== '';
    }

    function uniqueNames(fields) {
        var seen = {};
        return fields.filter(function (f) {
            if (seen[f.name]) return false;
            seen[f.name] = true;
            return true;
        });
    }

    function updateProgress() {
        var fields = uniqueNames(requiredFields());
        var filled = fields.filter(isFilled).length;
        var pct = fields.length ? Math.round((filled / fields.length) * 100) : 0;
        fill.style.width = pct + '%';
        pctLabel.textContent = pct + '%';
        var idx = Math.min(messages.length - 1, Math.floor(pct / 20));
        textLabel.textContent = messages[idx];
    }

    function updateEmojiSelection(changedInput) {
        var group = form.querySelectorAll('input[name="' + changedInput.name + '"]');
        group.forEach(function (input) {
            var option = input.closest('.sv-emoji-option');
            if (!option) return;
            option.classList.toggle('is-selected', input.checked);
        });
    }

    form.addEventListener('input', updateProgress);
    form.addEventListener('change', function (e) {
        updateProgress();
        if (e.target && e.target.type === 'radio') {
            updateEmojiSelection(e.target);
        }
    });
    updateProgress();
})();
</script>

@endsection
