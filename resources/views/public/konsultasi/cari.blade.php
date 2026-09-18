@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

<!-- Form Cari Konsultasi -->
                <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <form class="Konsultasi" action="/konsultasi/jadwal" method="get">
                            <label for="search" class="form-label">No Tiket</label>
                            <input type="search" class="form-control mb-2 @error('search') is-invalid @enderror" id="search" name="search" required value="{{ old('search') }}">

                            @error('search')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <div class="col text-center m-3">
                             <button type="submit" class="btn btn-primary mb-3" id="kirim">CARI</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                </section>
</main>

@include('layout.web.footer')
@endsection
