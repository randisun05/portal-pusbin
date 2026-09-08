@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

    <style>
        .vm-visi-card { background: linear-gradient(135deg, #3b4ba0, #5865c7); color: #fff; border-radius: 18px; padding: 40px 32px; }
        .vm-visi-card h4 { text-transform: uppercase; letter-spacing: 2px; font-size: .85rem; opacity: .8; margin-bottom: 14px; }
        .vm-visi-card p { font-size: 1.15rem; line-height: 1.7; margin: 0; }
        .vm-misi-item { display: flex; gap: 16px; align-items: flex-start; background: #fff; border: 1px solid #eceff3; border-radius: 12px; padding: 18px 20px; margin-bottom: 14px; transition: box-shadow .2s, transform .2s; }
        .vm-misi-item:hover { transform: translateX(4px); box-shadow: 0 8px 20px rgba(20,20,43,.08); }
        .vm-misi-num { flex: 0 0 auto; width: 34px; height: 34px; border-radius: 50%; background: #eef2ff; color: #3b4ba0; font-weight: 700; display: flex; align-items: center; justify-content: center; }
    </style>

    <div class="container-fluid py-5">
        <div class="container py-3 px-lg-5">

            <div class="row justify-content-center mb-5">
                <div class="col-lg-10">
                    <div class="vm-visi-card wow fadeInUp" data-wow-delay="0.1s">
                        <h4>Visi</h4>
                        @if($profil->visi)
                            <p>{{ $profil->visi }}</p>
                        @else
                            <p class="opacity-75">Visi organisasi belum diisi. Silakan lengkapi melalui menu admin &raquo; Profil Organisasi.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center mb-4 wow fadeInUp" data-wow-delay="0.1s">
                        <h3>Misi</h3>
                    </div>

                    @forelse($misis as $misi)
                        <div class="vm-misi-item wow fadeInLeft" data-wow-delay="{{ 0.1 + $loop->index * 0.1 }}s">
                            <div class="vm-misi-num">{{ $loop->iteration }}</div>
                            <div>{{ $misi->isi }}</div>
                        </div>
                    @empty
                        <p class="text-center text-muted">Misi organisasi belum diisi. Silakan tambahkan melalui menu admin &raquo; Misi.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</main>


@include('layout.web.footer')
@endsection
