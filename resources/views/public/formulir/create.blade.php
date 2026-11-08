@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')
@include('layout.partial.notif')

<style>
    .fm-rating { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 8px; }
    .fm-rating label { cursor: pointer; font-size: 1.6rem; color: #d8dbe0; transition: color .15s ease; }
    .fm-rating input { display: none; }
    .fm-rating input:checked ~ label,
    .fm-rating label:hover,
    .fm-rating label:hover ~ label { color: #ffab00; }
</style>

<main>
<section class="section">
<div class="container">
    <div class="row">
        <div class="col-md-7 offset-md-1">
            <h3 class="mb-2">{{ $formulir->judul }}</h3>
            @if($formulir->deskripsi)
                <p class="text-muted mb-4">{{ $formulir->deskripsi }}</p>
            @endif

            <form action="/form/{{ $formulir->slug }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('layout.partial.honeypot')
                @include('layout.partial.recaptcha')

                @foreach ($formulir->fields as $field)
                    <div class="mb-4">
                        <label class="form-label">
                            {{ $field->label }}
                            @if($field->wajib)<span class="text-danger">*</span>@endif
                        </label>

                        @switch($field->tipe)
                            @case('textarea')
                                <textarea class="form-control @error('data.'.$field->id) is-invalid @enderror" name="data[{{ $field->id }}]" rows="4" {{ $field->wajib ? 'required' : '' }}>{{ old('data.'.$field->id) }}</textarea>
                                @break

                            @case('number')
                                <input type="number" class="form-control @error('data.'.$field->id) is-invalid @enderror" name="data[{{ $field->id }}]" value="{{ old('data.'.$field->id) }}" {{ $field->wajib ? 'required' : '' }}>
                                @break

                            @case('email')
                                <input type="email" class="form-control @error('data.'.$field->id) is-invalid @enderror" name="data[{{ $field->id }}]" value="{{ old('data.'.$field->id) }}" {{ $field->wajib ? 'required' : '' }}>
                                @break

                            @case('date')
                                <input type="date" class="form-control @error('data.'.$field->id) is-invalid @enderror" name="data[{{ $field->id }}]" value="{{ old('data.'.$field->id) }}" {{ $field->wajib ? 'required' : '' }}>
                                @break

                            @case('select')
                                <select class="form-select @error('data.'.$field->id) is-invalid @enderror" name="data[{{ $field->id }}]" {{ $field->wajib ? 'required' : '' }}>
                                    <option value="" disabled {{ old('data.'.$field->id) ? '' : 'selected' }}>Pilih salah satu</option>
                                    @foreach ($field->opsiList() as $opsi)
                                        <option value="{{ $opsi }}" {{ old('data.'.$field->id) === $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                                    @endforeach
                                </select>
                                @break

                            @case('radio')
                                @foreach ($field->opsiList() as $i => $opsi)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="data[{{ $field->id }}]" id="field{{ $field->id }}_{{ $i }}" value="{{ $opsi }}" {{ old('data.'.$field->id) === $opsi ? 'checked' : '' }} {{ $field->wajib ? 'required' : '' }}>
                                        <label class="form-check-label" for="field{{ $field->id }}_{{ $i }}">{{ $opsi }}</label>
                                    </div>
                                @endforeach
                                @break

                            @case('checkbox')
                                @foreach ($field->opsiList() as $i => $opsi)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="data[{{ $field->id }}][]" id="field{{ $field->id }}_{{ $i }}" value="{{ $opsi }}" {{ in_array($opsi, (array) old('data.'.$field->id, [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="field{{ $field->id }}_{{ $i }}">{{ $opsi }}</label>
                                    </div>
                                @endforeach
                                @break

                            @case('file')
                                <input type="file" class="form-control @error('lampiran.'.$field->id) is-invalid @enderror" name="lampiran[{{ $field->id }}]" {{ $field->wajib ? 'required' : '' }}>
                                <div class="form-text">PDF/JPG/PNG/DOC/DOCX, maksimal 5MB.</div>
                                @error('lampiran.'.$field->id)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                @break

                            @case('rating')
                                <div class="fm-rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="data[{{ $field->id }}]" id="field{{ $field->id }}_r{{ $i }}" value="{{ $i }}" {{ old('data.'.$field->id) == $i ? 'checked' : '' }} {{ $field->wajib ? 'required' : '' }}>
                                        <label for="field{{ $field->id }}_r{{ $i }}" title="{{ $i }}">&#9733;</label>
                                    @endfor
                                </div>
                                @break

                            @default
                                <input type="text" class="form-control @error('data.'.$field->id) is-invalid @enderror" name="data[{{ $field->id }}]" value="{{ old('data.'.$field->id) }}" {{ $field->wajib ? 'required' : '' }}>
                        @endswitch

                        @error('data.'.$field->id)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                @endforeach

                <button type="submit" class="btn btn-primary">Kirim</button>
                <a href="/form" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
</section>
</main>

@include('layout.web.footer')
@endsection
