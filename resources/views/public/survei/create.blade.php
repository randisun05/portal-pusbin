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

                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" id="nip" value="{{ old('nip') }}" required>
                        @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <table class="table mt-4 align-middle">
                        @if($survei->type === 1)
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

                        @elseif ($survei->type === 2)
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

                        @elseif ($survei->type === 3)
                            <thead>
                                <tr>
                                    <th scope="col">Indikator</th>
                                    <th scope="col" class="text-center">Tidak Memuaskan</th>
                                    <th scope="col" class="text-center">1</th>
                                    <th scope="col" class="text-center">2</th>
                                    <th scope="col" class="text-center">3</th>
                                    <th scope="col" class="text-center">Sangat Memuaskan</th>
                                </tr>
                            </thead>
                            @foreach ($groups as $group)
                                <tr>
                                    <th scope="row">{{ $group->indikator->title }}</th>
                                    <td class="text-center"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="1" name="jawaban[{{ $group->indikator_id }}]" required></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="2" name="jawaban[{{ $group->indikator_id }}]"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="3" name="jawaban[{{ $group->indikator_id }}]"></td>
                                    <td class="text-center"></td>
                                </tr>
                            @endforeach

                        @elseif ($survei->type === 4)
                            <thead>
                                <tr>
                                    <th scope="col">Indikator</th>
                                    <th scope="col" class="text-center">Tidak Memuaskan</th>
                                    <th scope="col" class="text-center">1</th>
                                    <th scope="col" class="text-center">2</th>
                                    <th scope="col" class="text-center">3</th>
                                    <th scope="col" class="text-center">4</th>
                                    <th scope="col" class="text-center">Sangat Memuaskan</th>
                                </tr>
                            </thead>
                            @foreach ($groups as $group)
                                <tr>
                                    <th scope="row">{{ $group->indikator->title }}</th>
                                    <td class="text-center"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="1" name="jawaban[{{ $group->indikator_id }}]" required></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="2" name="jawaban[{{ $group->indikator_id }}]"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="3" name="jawaban[{{ $group->indikator_id }}]"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="4" name="jawaban[{{ $group->indikator_id }}]"></td>
                                    <td class="text-center"></td>
                                </tr>
                            @endforeach
                        @else
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
                        @endif
                    </table>

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

    form.addEventListener('input', updateProgress);
    form.addEventListener('change', updateProgress);
    updateProgress();
})();
</script>

@endsection
