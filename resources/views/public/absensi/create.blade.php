@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')
@include('layout.partial.notif')

<style>
    .ab-step-indicator { display: flex; justify-content: center; gap: 8px; margin-bottom: 24px; }
    .ab-step-dot { width: 34px; height: 34px; border-radius: 50%; background: #eceff3; color: #6c7382; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .85rem; transition: all .2s ease; }
    .ab-step-dot.is-active { background: var(--accent-color, #b5261f); color: #fff; }
    .ab-step-dot.is-done { background: #71dd37; color: #fff; }
    .ab-step { display: none; }
    .ab-step.is-visible { display: block; animation: abFadeIn .35s ease; }
    @keyframes abFadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

    .ab-emoji-options { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; margin: 20px 0; }
    .ab-emoji-option { position: relative; flex: 1 1 0; min-width: 92px; display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 16px 8px; border-radius: 14px; border: 2px solid #eceff3; background: #f7f8fa; cursor: pointer; text-align: center; transition: transform .15s ease, border-color .15s ease, background-color .15s ease; }
    .ab-emoji-option input { position: absolute; opacity: 0; width: 100%; height: 100%; margin: 0; cursor: pointer; }
    .ab-emoji-option .ab-emoji { font-size: 2.1rem; line-height: 1; filter: grayscale(60%); opacity: .65; transition: filter .15s ease, opacity .15s ease, transform .15s ease; }
    .ab-emoji-option .ab-emoji-text { font-size: .72rem; color: #6c7382; font-weight: 700; }
    .ab-emoji-option:hover { transform: translateY(-2px); background: #eef0f4; }
    .ab-emoji-option.is-selected { border-color: var(--ab-color); background: var(--ab-bg); }
    .ab-emoji-option.is-selected .ab-emoji { filter: grayscale(0%); opacity: 1; transform: scale(1.2); }
    .ab-emoji-option.is-selected .ab-emoji-text { color: var(--ab-color); }

    .ab-success-wrap { text-align: center; padding: 30px 10px; position: relative; overflow: hidden; }
    .ab-success-check { width: 84px; height: 84px; border-radius: 50%; background: #71dd37; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; font-size: 2.4rem; animation: abPop .5s cubic-bezier(.26,1.36,.56,1.29); }
    @keyframes abPop { 0% { transform: scale(0); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
    .ab-confetti { position: absolute; top: -10px; width: 8px; height: 14px; opacity: .9; animation: abFall 2.2s ease-in forwards; }
    @keyframes abFall { to { transform: translateY(260px) rotate(360deg); opacity: 0; } }
</style>

<main>
<section class="section">
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            @if ($presensiTertutup)
                <div class="alert alert-warning text-center">
                    <i class="bi bi-clock-history me-2"></i>
                    Batas waktu presensi untuk kegiatan ini sudah berakhir
                    ({{ \Carbon\Carbon::parse($kegiatan->batas_presensi)->translatedFormat('d F Y, H:i') }} WIB).
                    Presensi tidak dapat diisi lagi.
                </div>
                <div class="text-center">
                    <a href="/absensi" class="btn btn-outline-secondary">Kembali ke Daftar Kegiatan</a>
                </div>
            @else
            @if ($kegiatan->batas_presensi)
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i>
                    Presensi ditutup pada {{ \Carbon\Carbon::parse($kegiatan->batas_presensi)->translatedFormat('d F Y, H:i') }} WIB.
                </div>
            @endif

            <div class="ab-step-indicator" id="abStepIndicator">
                <div class="ab-step-dot is-active" data-step="1">1</div>
                <div class="ab-step-dot" data-step="2">2</div>
            </div>

            <form id="form-absensi" action="/absensi/{{ $kegiatan->slug }}/store" method="POST" enctype="multipart/form-data">
                @csrf
                @include('layout.partial.honeypot')
                @include('layout.partial.recaptcha')
                <input type="hidden" id="kegiatan_id" name="kegiatan_id" value="{{ $kegiatan->id }}">

                {{-- LANGKAH 1: DATA DIRI --}}
                <div class="ab-step is-visible" id="abStep1">
                    <h4 class="text-center mb-4">Data Kehadiran</h4>

                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip"
                            required maxlength="18" value="{{ old('nip') }}"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Masukan NIP">
                        @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">NAMA LENGKAP</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                            required value="{{ old('nama') }}" placeholder="Masukan nama lengkap">
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">EMAIL AKTIF</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" required value="{{ old('email') }}" placeholder="Masukan email aktif">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="jabatan" class="form-label">JABATAN</label>
                        <select class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
                             name="jabatan" required>
                            <option value="" disabled {{ old('jabatan') ? '' : 'selected' }}>Pilih Jabatan</option>
                            <option value="Analis SDM Aparatur" {{ old('jabatan') == 'Analis SDM Aparatur' ? 'selected' : '' }}>Analis SDM Aparatur</option>
                            <option value="Asesor SDM Aparatur" {{ old('jabatan') == 'Asesor SDM Aparatur' ? 'selected' : '' }}>Asesor SDM Aparatur</option>
                            <option value="Auditor Manajemen ASN" {{ old('jabatan') == 'Auditor Manajemen ASN' ? 'selected' : '' }}>Auditor Manajemen ASN</option>
                            <option value="Pranata SDM Aparatur" {{ old('jabatan') == 'Pranata SDM Aparatur' ? 'selected' : '' }}>Pranata SDM Aparatur</option>
                        </select>
                        @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="instansi" class="form-label">INSTANSI</label>
                        <input type="text" class="form-control @error('instansi') is-invalid @enderror" id="instansi"
                            name="instansi" required value="{{ old('instansi') }}" placeholder="Masukan Instansi">
                        @error('instansi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col text-center m-3">
                        <button type="button" class="btn btn-primary" id="btnLanjut">Lanjut <i class="bi bi-arrow-right"></i></button>
                        <a href="/absensi" class="btn btn-outline-secondary" id="batal">Batal</a>
                    </div>
                </div>

                {{-- LANGKAH 2: KEPUASAN & SARAN --}}
                <div class="ab-step" id="abStep2">
                    <h4 class="text-center mb-2">Bagaimana Kesan Anda?</h4>
                    <p class="text-muted text-center mb-0">Sebelum absen tersimpan, ceritakan singkat pengalaman Anda di kegiatan ini.</p>

                    <div class="ab-emoji-options">
                        @php
                            $abScale = [
                                1 => ['emoji' => '😠', 'label' => 'Kurang', 'color' => '#ff3e1d'],
                                2 => ['emoji' => '😐', 'label' => 'Cukup', 'color' => '#ffab00'],
                                3 => ['emoji' => '🙂', 'label' => 'Baik', 'color' => '#03c3ec'],
                                4 => ['emoji' => '😄', 'label' => 'Sangat Baik', 'color' => '#71dd37'],
                            ];
                        @endphp
                        @foreach ($abScale as $nilai => $opt)
                            <label class="ab-emoji-option" style="--ab-color: {{ $opt['color'] }}; --ab-bg: {{ $opt['color'] }}1a;">
                                <input type="radio" value="{{ $nilai }}" name="rating" id="rating{{ $nilai }}">
                                <span class="ab-emoji">{{ $opt['emoji'] }}</span>
                                <span class="ab-emoji-text">{{ $opt['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="invalid-feedback d-block text-center @error('rating') @else d-none @enderror" id="abRatingError">
                        {{ $errors->first('rating') ?: 'Silakan pilih salah satu penilaian.' }}
                    </div>

                    <div class="mb-3 mt-4">
                        <label for="saran" class="form-label">Saran / Masukan (opsional)</label>
                        <textarea class="form-control @error('saran') is-invalid @enderror" id="saran" name="saran" rows="3" placeholder="Tulis masukan Anda...">{{ old('saran') }}</textarea>
                        @error('saran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="lampiran" class="form-label">Lampiran (opsional)</label>
                        <input type="file" class="form-control @error('lampiran') is-invalid @enderror" id="lampiran" name="lampiran">
                        <div class="form-text">PDF/JPG/PNG/DOC/DOCX, maksimal 5MB.</div>
                        @error('lampiran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col text-center m-3">
                        <button type="submit" class="btn btn-primary" id="btnAbsen">Absen Sekarang <i class="bi bi-check2-circle"></i></button>
                        <button type="button" class="btn btn-outline-secondary" id="btnKembali">Kembali</button>
                    </div>
                </div>
            </form>

            {{-- LANGKAH 3: SUKSES --}}
            <div class="ab-step" id="abStep3">
                <div class="ab-success-wrap" id="abSuccessWrap">
                    <div class="ab-success-check"><i class="bi bi-check-lg"></i></div>
                    <h4 id="abSuccessTitle">Absen Berhasil!</h4>
                    <p class="text-muted" id="abSuccessMessage">Terima kasih atas kehadiran dan masukan Anda.</p>
                    <a href="/absensi" class="btn btn-primary mt-2">Selesai</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</section>
</main>


@include('layout.web.footer')

<script>
(function () {
    var form = document.getElementById('form-absensi');
    if (!form) return;

    var step1 = document.getElementById('abStep1');
    var step2 = document.getElementById('abStep2');
    var step3 = document.getElementById('abStep3');
    var indicator = document.getElementById('abStepIndicator');
    var btnLanjut = document.getElementById('btnLanjut');
    var btnKembali = document.getElementById('btnKembali');
    var btnAbsen = document.getElementById('btnAbsen');
    var ratingError = document.getElementById('abRatingError');

    function setStepIndicator(step) {
        indicator.querySelectorAll('.ab-step-dot').forEach(function (dot) {
            var n = parseInt(dot.dataset.step, 10);
            dot.classList.toggle('is-active', n === step);
            dot.classList.toggle('is-done', n < step || step > 2);
        });
    }

    function goToStep2() {
        var fields = step1.querySelectorAll('input[required], select[required]');
        for (var i = 0; i < fields.length; i++) {
            if (!fields[i].checkValidity()) {
                fields[i].reportValidity();
                return;
            }
        }
        step1.classList.remove('is-visible');
        step2.classList.add('is-visible');
        setStepIndicator(2);
    }

    if (btnLanjut) {
        btnLanjut.addEventListener('click', goToStep2);
    }

    if (btnKembali) {
        btnKembali.addEventListener('click', function () {
            step2.classList.remove('is-visible');
            step1.classList.add('is-visible');
            setStepIndicator(1);
        });
    }

    form.querySelectorAll('.ab-emoji-option input').forEach(function (input) {
        input.addEventListener('change', function () {
            form.querySelectorAll('.ab-emoji-option').forEach(function (opt) {
                opt.classList.remove('is-selected');
            });
            input.closest('.ab-emoji-option').classList.add('is-selected');
            ratingError.classList.add('d-none');
        });
    });

    function spawnConfetti(container) {
        var colors = ['#b5261f', '#ffab00', '#71dd37', '#03c3ec', '#fd346e'];
        for (var i = 0; i < 24; i++) {
            var piece = document.createElement('span');
            piece.className = 'ab-confetti';
            piece.style.left = Math.round(Math.random() * 100) + '%';
            piece.style.background = colors[i % colors.length];
            piece.style.animationDelay = (Math.random() * 0.4) + 's';
            container.appendChild(piece);
        }
        setTimeout(function () {
            container.querySelectorAll('.ab-confetti').forEach(function (p) { p.remove(); });
        }, 2600);
    }

    form.addEventListener('submit', function (e) {
        var checkedRating = form.querySelector('input[name="rating"]:checked');
        if (!checkedRating) {
            e.preventDefault();
            ratingError.classList.remove('d-none');
            return;
        }

        if (typeof window.fetch !== 'function') {
            return; // fallback: biarkan submit normal (progressive enhancement)
        }

        e.preventDefault();
        btnAbsen.disabled = true;
        btnAbsen.innerHTML = 'Mengirim...';

        var namaValue = form.querySelector('#nama').value.trim();
        var formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: formData,
        }).then(function (res) {
            if (!res.ok) {
                throw new Error('request-failed');
            }
            return res.json();
        }).then(function (data) {
            step2.classList.remove('is-visible');
            step3.classList.add('is-visible');
            setStepIndicator(3);
            document.getElementById('abSuccessTitle').textContent = 'Absen Berhasil, ' + (namaValue || 'Peserta') + '!';
            document.getElementById('abSuccessMessage').textContent = data.message || 'Terima kasih atas kehadiran dan masukan Anda.';
            spawnConfetti(document.getElementById('abSuccessWrap'));
        }).catch(function () {
            // Fallback: submit form biasa supaya pesan error dari server (mis. sudah absen,
            // presensi ditutup) tetap tampil lewat alur redirect + flash message normal.
            btnAbsen.disabled = false;
            btnAbsen.innerHTML = 'Absen Sekarang';
            HTMLFormElement.prototype.submit.call(form);
        });
    });
})();
</script>
@endsection
