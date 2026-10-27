@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

    <style>
        .vm-visi-card { background: linear-gradient(135deg, var(--accent-color), #fd346e); color: #fff; border-radius: 18px; padding: 40px 32px; }
        .vm-visi-card h4 { text-transform: uppercase; letter-spacing: 2px; font-size: .85rem; opacity: .8; margin-bottom: 14px; }
        .vm-visi-card p { font-size: 1.15rem; line-height: 1.7; margin: 0; }
        .vm-misi-item { display: flex; gap: 16px; align-items: flex-start; background: var(--surface-color); border: 1px solid color-mix(in srgb, var(--default-color), transparent 90%); border-radius: 12px; padding: 18px 20px; margin-bottom: 14px; transition: box-shadow .2s, transform .2s; }
        .vm-misi-item:hover { transform: translateX(4px); box-shadow: 0 8px 20px rgba(20,20,43,.08); }
        .vm-misi-num { flex: 0 0 auto; width: 34px; height: 34px; border-radius: 50%; background: color-mix(in srgb, var(--accent-color), transparent 90%); color: var(--accent-color); font-weight: 700; display: flex; align-items: center; justify-content: center; }
    </style>

    <section class="section">
        <div class="container">

            <div class="row justify-content-center mb-5">
                <div class="col-lg-10">
                    <div class="vm-visi-card" data-aos="fade-up">
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
                    <div class="text-center mb-4" data-aos="fade-up">
                        <h3>Misi</h3>
                    </div>

                    @forelse($misis as $misi)
                        <div class="vm-misi-item" data-aos="fade-up" data-aos-delay="{{ 100 + $loop->index * 50 }}">
                            <div class="vm-misi-num">{{ $loop->iteration }}</div>
                            <div>{{ $misi->isi }}</div>
                        </div>
                    @empty
                        <p class="text-center text-muted">Misi organisasi belum diisi. Silakan tambahkan melalui menu admin &raquo; Misi.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </section>
</main>


@include('layout.web.footer')
@endsection
