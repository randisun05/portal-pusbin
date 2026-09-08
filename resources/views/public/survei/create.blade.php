@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.partial.notif')

<main>
@include('layout.web.header-detail')

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

                <form action="/survei/{{ $survei->id }}" method="POST">
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
@endsection
