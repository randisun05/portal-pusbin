@extends('layout.main-main')
@section('container')
@include('layout.partial.header-componen')

<!-- Form Usulan Konsultasi -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 offset-md-4">

                            @if (session()->has('success'))
                            <div class="alert alert-success col-lg-8" role="alert">
                            {{session('success')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                        <form class="Konsultasi" action="/konsultasi/" method="POST">
                                @csrf
                            {{-- NIP --}}
                            <label for="nip" class="form-label mt-4">NIP</label>
                            <input type="text" class="form-control mb-2 @error('nip') is-invalid @enderror" id="nip" name="nip" required maxlength="25" value="{{ old('nip') }}" onkeypress="return onlyNumberKey(event)">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-3">Cari NIP</button>
                            </div>

                            @error('nip')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            {{-- NAMA --}}
                            <label for="nama" class="form-label">NAMA LENGKAP</label>
                            <input type="text" class="form-control mb-2" id="nama" name="nama" disabled>

                            {{-- JABATAN --}}
                            <label for="jabatan_sekarang" class="form-label">JABATAN</label>
                            <input type="text" class="form-control mb-2" id="jabatan" name="jabatan" disabled>

                            {{-- INSTANSI --}}
                            <label for="instansi" class="form-label">INSTANSI</label>
                            <input type="text" class="form-control mb-2" id="instansi" name="instansi" disabled>

                            {{-- PERIHAL KONSULTASI --}}
                            <label for="perihal" class="form-label">PERIHAL KONSULTASI</label>
                            <select class="form-select @error('kode_id') is-invalid @enderror" name="kode_id">
                                @foreach ($kode as $kode )
                                    @if (old('kode_id') == $kode->id)
                                        <option value="{{$kode->id}}" selected>{{$kode->jenis}}</option>
                                    @else
                                    <option value="{{$kode->id}}">{{$kode->jenis}}</option>
                                @endif
                                @endforeach
                            </select>

                              @error('kode_id')
                                <div class="invalid-feedback">
                                    {{ $message}}
                                </div>
                              @enderror

                             {{-- Deskripsi Perihal --}}
                             <label for="deskripsi" class="form-label mt-2">DESKRIPSI PERIHAL</label>
                             <textarea class="form-control mb-2 @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" required value="{{ old('deskripsi') }}" style="height: 100px"></textarea>
                             @error('deskripsi')
                                 <div class="invalid-feedback">
                                     {{ $message }}
                                 </div>
                             @enderror

                            {{-- PILIH TANGGAL --}}
                            <label for="tingkat" class="form-label">PILIH JADWAL</label>
                            <div class="input-group mb-3">
                                <input type="date"  class="form-control @error('jadwal')is-invalid @enderror"  id="jadwal" name="jadwal"  data-toggle="datetimepicker" data-target="#jadwal" aria-describedby="basic-addon2" required>
                            </div>
                            @error('jadwal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror


                            {{-- Button --}}
                            <div class="col text-center m-3">
                             <button type="submit" class="btn btn-primary mb-3" class="" id="kirim">KIRIM USULAN</button>
                            </div>
                        </form>

                            <div class="text-center">
                            <a href="/konsultasi/cari"><u>Cari No Tiket</u></a>
                            </div>
                        </div>
                    </div>
                </div>


@include('layout.partial.footer')


<script>
    // Add a change event listener to the dropdown list
    const kodeDropdown = document.getElementById('kode_id');
    kodeDropdown.addEventListener('change', function() {
        // Get the selected option from the dropdown list
        const selectedOption = this.options[this.selectedIndex];
        // Set the value of the input field to the selected option's value
        document.getElementById('jenis').value = selectedOption.dataset.kode;
    });
</script>
@endsection
