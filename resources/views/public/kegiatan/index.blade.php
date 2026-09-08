@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')
@include('layout.partial.notif')

<main>
    <div class="container mt-50">
        @if($daftarJenis->count())
        <div class="d-flex flex-wrap gap-2 mb-4">
            <a href="/kegiatan" class="tp-btn {{ $jenisAktif ? 'tp-btn-transparent' : 'tp-btn-insu' }} tp-btn-sm">Semua</a>
            @foreach($daftarJenis as $jenis)
                <a href="/kegiatan?jenis={{ urlencode($jenis) }}" class="tp-btn {{ $jenisAktif === $jenis ? 'tp-btn-insu' : 'tp-btn-transparent' }} tp-btn-sm">{{ $jenis }}</a>
            @endforeach
        </div>
        @endif
        @if ($kegiatans->count())
        <div class="row">
            @foreach ($kegiatans as $kegiatan)
            <div class="col-lg-4 col-md-6">
                <div class="tp-blog-wrapper mb-50 wow fadeInUp" data-wow-delay=".3s" data-wow-duration="1s">
                    <div class="tp-blog-main-img mb-15 p-relative">
                        <img class="w-img" src="{{asset ('assets/img/konsul2.png') }}" alt="blog">
                        <img class="w-img" src="{{asset ('assets/img/konsul2.png') }}" alt="blog">
                    </div>
                    <div class="tp-blog-content">
                        <div class="tp-blog-meta mb-15">
                            <span class="tp-blog-sub-meta tp-blog-sub-meta-fin p-relative"><a href="absensi/{{ $kegiatan->slug }}">{{$kegiatan->waktu}}</a></span>
                            <span class="tp-blog-date p-relative">23 June, 2024</span>
                        </div>
                        <h3 class="tp-blog-title tp-blog-title-2 mb-25"><a href="absensi/{{ $kegiatan->slug }}">{{ $kegiatan->nama }}</a></h3>
                        <a href="kegiatan/{{ $kegiatan->slug }}" class="tp-blog-btn-2">View<i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{$kegiatans->links()}}
        </div>
        @else
        <p class="text-center fs-4">No Event Found.</p>
        @endif
    </div>
</main>


@include('layout.web.footer')
@endsection
