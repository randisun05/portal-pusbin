@extends('layout.main-main')
@section('container')
@include('layout.partial.header-componen')

<!-- Form Usulan Konsultasi -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 offset-md-4">

                        <form class="Absensi" action="/absensi/{{$kegiatan->slug}}/berhasil" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="hidden" id="kegiatan_id" name="kegiatan_id" value="{{$kegiatan->id}}">
                                </div>

                            {{-- NIP --}}
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control mb-2 @error('nip') is-invalid @enderror" id="nip" name="nip" required maxlength="18" value="{{ old('nip') }}" onkeypress="return onlyNumberKey(event)">

                            @error('nip')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            {{-- NAMA --}}
                            <label for="nama" class="form-label">NAMA LENGKAP</label>
                            <input type="text" class="form-control mb-2 @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('name') }}">

                            {{-- JABATAN --}}
                            <label for="jabatan" class="form-label">JABATAN</label>
                            <input type="text" class="form-control mb-2 @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" name="jabatan" value="{{ old('jabatan') }}">

                            {{-- INSTANSI --}}
                            <label for="instansi" class="form-label">INSTANSI</label>
                            <input type="text" class="form-control mb-2 @error('instansi') is-invalid @enderror" id="instansi" name="instansi" value="{{ old('instansi') }}"    >


                            {{-- Button --}}
                            <div class="col text-center m-3">
                             <button type="submit" class="btn btn-primary mb-3" class="" id="kirim">ABSEN</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

<script>
                const title = document.querySelector('#id');
                const slug = document.querySelector('#nip');

                title.addEventListener('change', function(){
                    fetch('/admin/publikasi/checkSlug?title=' + title.value)
                    .then(response => response.json())
                    .then(data => slug.value = data.slug)
                });


</script>
@include('layout.partial.footer')
@endsection
