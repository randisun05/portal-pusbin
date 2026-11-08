{{--
    Overlay skeleton saat halaman dimuat / berpindah halaman
    (lihat public/assets-flexor/css/skeleton.css dan js/skeleton.js).
    Varian: public (default), landing (beranda), admin. Pasang tepat setelah <body>.
    Menggantikan preloader spinner bawaan template Flexor.
--}}
@php($variant = $variant ?? 'public')
<noscript><style>#page-skeleton { display: none !important; }</style></noscript>
<div id="page-skeleton" data-state="loading" data-variant="{{ $variant }}" aria-hidden="true">
    <div class="skel-bar"></div>
    @if ($variant === 'admin')
        <div class="skel-admin">
            <div class="skel-side">
                <div class="skel-row"><span class="skel skel-circle" style="--w:32px;--h:32px"></span><span class="skel" style="--w:60%;--h:20px"></span></div>
                @foreach (range(1, 10) as $i)
                    <div class="skel-row"><span class="skel" style="--w:22px;--h:22px"></span><span class="skel" style="--w:{{ 45 + ($i * 7) % 35 }}%"></span></div>
                @endforeach
            </div>
            <div class="skel-main">
                <div class="skel-panel" style="flex-direction:row;align-items:center;justify-content:space-between;padding:14px 20px">
                    <span class="skel" style="--w:min(280px,50%);--h:22px"></span>
                    <span class="skel skel-circle" style="--w:36px;--h:36px"></span>
                </div>
                <div class="skel" style="--w:min(320px,60%);--h:26px;margin:28px auto 20px"></div>
                <div class="skel-panel">
                    <span class="skel" style="--w:130px;--h:34px"></span>
                    @foreach (range(1, 7) as $i)
                        <div class="skel-table-row">
                            <span class="skel" style="--h:14px"></span>
                            <span class="skel" style="--h:14px"></span>
                            <span class="skel" style="--h:14px"></span>
                            <span class="skel" style="--h:14px"></span>
                            <span class="skel" style="--h:22px"></span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="skel-topbar"></div>
        <div class="skel-branding">
            <div class="skel-logo">
                <span class="skel" style="--w:42px;--h:42px;--r:8px"></span>
                <div class="skel-logo-text">
                    <span class="skel" style="--w:130px;--h:12px"></span>
                    <span class="skel" style="--w:90px;--h:10px"></span>
                </div>
            </div>
            <div class="skel-nav-links">
                @foreach (range(1, 6) as $i)<span class="skel" style="--w:58px;--h:12px"></span>@endforeach
            </div>
        </div>

        {{-- Dua bentuk badan: beranda (hero) dan halaman biasa; dipilih lewat data-variant --}}
        <div class="skel-body skel-body-landing">
            <div class="skel-hero">
                <span class="skel" style="--w:min(560px,90%);--h:44px"></span>
                <span class="skel" style="--w:min(440px,75%);--h:44px"></span>
                <span class="skel" style="--w:min(520px,85%);--h:16px;margin-top:8px"></span>
                <span class="skel" style="--w:min(400px,70%);--h:16px"></span>
                <span class="skel" style="--w:160px;--h:44px;--r:4px;margin-top:12px"></span>
            </div>
            <div class="skel-cards">
                @foreach (range(1, 3) as $i)
                    <div class="skel-card">
                        <span class="skel skel-circle" style="--w:48px;--h:48px"></span>
                        <span class="skel" style="--w:60%;--h:18px"></span>
                        <span class="skel"></span>
                        <span class="skel" style="--w:80%"></span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="skel-body skel-body-public">
            <div class="skel-pagetitle">
                <span class="skel" style="--w:min(380px,80%);--h:32px"></span>
                <span class="skel" style="--w:min(220px,50%);--h:12px"></span>
            </div>
            <div class="skel-cards">
                @foreach (range(1, 6) as $i)
                    <div class="skel-card">
                        <span class="skel" style="--h:130px;--r:6px"></span>
                        <span class="skel" style="--w:70%;--h:18px"></span>
                        <span class="skel"></span>
                        <span class="skel" style="--w:85%"></span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
