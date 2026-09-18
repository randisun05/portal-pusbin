@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Profil Organisasi</h1>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <form action="/admin/profil" method="POST">
                @method('put')
                @csrf
                <div class="form-group mt-4 ms-5 me-5">

                    <h5 class="mb-3">Beranda (Homepage)</h5>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="hero_judul" class="form-label">Judul Hero</label>
                            <input type="text" class="form-control" @error('hero_judul') is-invalid @enderror name="hero_judul" id="hero_judul" value="{{old('hero_judul', $profil->hero_judul)}}" placeholder="Direktorat Jabatan Fungsional MASN">
                            @error('hero_judul')<div class="invalid-feedback">{{$message}}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="about_judul" class="form-label">Judul Bagian Tentang (Beranda)</label>
                            <input type="text" class="form-control" @error('about_judul') is-invalid @enderror name="about_judul" id="about_judul" value="{{old('about_judul', $profil->about_judul)}}" placeholder="Pelaksanaan Uji Kompetensi JFK">
                            @error('about_judul')<div class="invalid-feedback">{{$message}}</div>@enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="hero_deskripsi" class="form-label">Deskripsi Hero</label>
                            <textarea class="form-control" @error('hero_deskripsi') is-invalid @enderror name="hero_deskripsi" id="hero_deskripsi" rows="2" placeholder="Membina, mengembangkan, dan memfasilitasi jabatan fungsional kepegawaian...">{{old('hero_deskripsi', $profil->hero_deskripsi)}}</textarea>
                            @error('hero_deskripsi')<div class="invalid-feedback">{{$message}}</div>@enderror
                        </div>
                    </div>

                    <h6 class="mb-3">Label Statistik Beranda</h6>
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <label for="stat_label_organisasi" class="form-label">Label #1</label>
                            <input type="text" class="form-control" name="stat_label_organisasi" id="stat_label_organisasi" value="{{old('stat_label_organisasi', $profil->stat_label_organisasi)}}" placeholder="Pejabat &amp; Tim">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="stat_label_layanan" class="form-label">Label #2</label>
                            <input type="text" class="form-control" name="stat_label_layanan" id="stat_label_layanan" value="{{old('stat_label_layanan', $profil->stat_label_layanan)}}" placeholder="Layanan Aktif">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="stat_label_kegiatan" class="form-label">Label #3</label>
                            <input type="text" class="form-control" name="stat_label_kegiatan" id="stat_label_kegiatan" value="{{old('stat_label_kegiatan', $profil->stat_label_kegiatan)}}" placeholder="Kegiatan Terlaksana">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="stat_label_publikasi" class="form-label">Label #4</label>
                            <input type="text" class="form-control" name="stat_label_publikasi" id="stat_label_publikasi" value="{{old('stat_label_publikasi', $profil->stat_label_publikasi)}}" placeholder="Publikasi">
                        </div>
                    </div>
                    <p class="text-muted">
                        Untuk mengatur 3 kotak alasan di Hero, 3 poin di bagian Tentang, dan 4 kartu Fungsi &amp; Layanan Interaktif,
                        gunakan menu <a href="/admin/highlight">Konten Beranda (Highlight)</a>.
                    </p>

                    <h5 class="mb-3 mt-4">Tentang Kami</h5>
                    <div class="mb-4">
                        <label for="tentang" class="form-label">Isi Halaman Tentang Kami</label>
                        <textarea class="form-control" @error('tentang') is-invalid @enderror name="tentang" id="tentang" rows="8" placeholder="Tuliskan profil singkat organisasi...">{{old('tentang', $profil->tentang)}}</textarea>
                        @error('tentang')<div class="invalid-feedback">{{$message}}</div>@enderror
                    </div>

                    <h5 class="mb-3 mt-4">Visi</h5>
                    <div class="mb-4">
                        <label for="visi" class="form-label">Visi Organisasi</label>
                        <textarea class="form-control" @error('visi') is-invalid @enderror name="visi" id="visi" rows="3">{{old('visi', $profil->visi)}}</textarea>
                        @error('visi')<div class="invalid-feedback">{{$message}}</div>@enderror
                        <small class="text-muted">Untuk mengatur daftar Misi, gunakan menu <a href="/admin/misi">Misi</a>.</small>
                    </div>

                    <h5 class="mb-3 mt-4">Kontak</h5>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" @error('alamat') is-invalid @enderror name="alamat" id="alamat" rows="3">{{old('alamat', $profil->alamat)}}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{$message}}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" class="form-control" @error('telepon') is-invalid @enderror name="telepon" id="telepon" value="{{old('telepon', $profil->telepon)}}">
                                @error('telepon')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" @error('email') is-invalid @enderror name="email" id="email" value="{{old('email', $profil->email)}}">
                                @error('email')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="jam_operasional" class="form-label">Jam Operasional</label>
                                <input type="text" class="form-control" @error('jam_operasional') is-invalid @enderror name="jam_operasional" id="jam_operasional" value="{{old('jam_operasional', $profil->jam_operasional)}}" placeholder="Senin - Jumat, 08.00 - 16.00 WIB">
                                @error('jam_operasional')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="maps_embed" class="form-label">Embed Google Maps (URL src iframe)</label>
                        <input type="text" class="form-control" @error('maps_embed') is-invalid @enderror name="maps_embed" id="maps_embed" value="{{old('maps_embed', $profil->maps_embed)}}" placeholder="https://www.google.com/maps/embed?...">
                        @error('maps_embed')<div class="invalid-feedback">{{$message}}</div>@enderror
                    </div>

                    <h5 class="mb-3 mt-4">Media Sosial</h5>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="instagram" class="form-label">Instagram</label>
                            <input type="text" class="form-control" name="instagram" id="instagram" value="{{old('instagram', $profil->instagram)}}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input type="text" class="form-control" name="facebook" id="facebook" value="{{old('facebook', $profil->facebook)}}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="youtube" class="form-label">YouTube</label>
                            <input type="text" class="form-control" name="youtube" id="youtube" value="{{old('youtube', $profil->youtube)}}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="twitter" class="form-label">Twitter / X</label>
                            <input type="text" class="form-control" name="twitter" id="twitter" value="{{old('twitter', $profil->twitter)}}">
                        </div>
                    </div>

                </div>
                <div class="text-center mb-4">
                    <button class="btn btn-lg btn-primary" type="submit">Simpan Profil</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
