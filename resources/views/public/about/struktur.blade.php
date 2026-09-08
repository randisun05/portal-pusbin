@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
<main>
@include('layout.web.header-detail')

    <style>
        .org-chart-wrap { overflow-x: auto; padding-bottom: 1rem; }
        .org-chart { display: flex; justify-content: center; min-width: 600px; padding-top: 1rem; }
        .org-chart ul { list-style: none; margin: 0; padding-top: 2rem; position: relative; display: flex; }
        .org-chart li { list-style: none; margin: 0 1rem; padding-top: 2rem; position: relative; text-align: center; }
        .org-chart > ul { padding-top: 0; }
        .org-chart li::before {
            content: ''; position: absolute; top: 0; left: 50%; height: 2rem; border-left: 2px solid #d7dbe3;
        }
        .org-chart > ul > li::before { display: none; }
        .org-chart ul ul::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2rem; border-top: 2px solid #d7dbe3;
        }
        .org-chart ul.org-children { padding-top: 2rem; }
        .org-chart li.org-node:only-child { padding-top: 0; }
        .org-chart li.org-node:only-child::before,
        .org-chart li.org-node:only-child > .org-children::before { display: none; }
        .org-card {
            display: inline-block; background: #fff; border: 1px solid #eceff3; border-radius: 12px;
            padding: 14px 16px; min-width: 170px; box-shadow: 0 4px 14px rgba(20,20,43,.06); position: relative;
            transition: box-shadow .2s, transform .2s;
        }
        .org-card:hover { box-shadow: 0 8px 22px rgba(20,20,43,.12); transform: translateY(-2px); }
        .org-photo { width: 56px; height: 56px; border-radius: 50%; margin: 0 auto 8px; overflow: hidden; background: #eef1f6; display: flex; align-items: center; justify-content: center; }
        .org-photo img { width: 100%; height: 100%; object-fit: cover; }
        .org-photo-fallback { font-weight: 700; font-size: 1.1rem; color: #6c7382; }
        .org-nama { font-size: .92rem; margin: 0; font-weight: 700; }
        .org-jabatan { display: block; font-size: .78rem; color: #6c7382; margin-top: 2px; }
        .org-unit { display: inline-block; margin-top: 6px; font-size: .68rem; background: #fdeceb; color: #f92c24; padding: 2px 8px; border-radius: 20px; }
        .org-toggle {
            position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%);
            width: 20px; height: 20px; border-radius: 50%; border: 1px solid #d7dbe3; background: #fff;
            font-size: .65rem; line-height: 1; display: flex; align-items: center; justify-content: center;
            cursor: pointer; z-index: 2; color: #444;
        }
        .org-children.collapsed { display: none; }

        .org-search-bar { max-width: 420px; }
        .org-filter-chip { cursor: pointer; border: 1px solid #d7dbe3; background: #fff; border-radius: 20px; padding: 6px 16px; font-size: .82rem; margin: 4px; display: inline-block; transition: all .15s; }
        .org-filter-chip.active, .org-filter-chip:hover { background: #f92c24; color: #fff; border-color: #f92c24; }
        .org-empty-state { display: none; text-align: center; padding: 2rem; color: #6c7382; }
    </style>

    <div class="container-fluid py-5">
        <div class="container py-3 px-lg-5">

            {{-- ================= BAGAN STRUKTUR INTERAKTIF ================= --}}
            <div class="text-center wow fadeInUp mb-4" data-wow-delay="0.1s">
                <h3>Bagan Struktur Organisasi</h3>
                <p class="text-muted">Klik tombol pada tiap kotak untuk melipat/membuka susunan di bawahnya.</p>
            </div>

            @if($tree->isEmpty())
                <div class="text-center text-muted py-4 mb-5">
                    Data struktur organisasi belum tersedia.
                </div>
            @else
                <div class="org-chart-wrap mb-5 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="org-chart">
                        <ul>
                            @foreach($tree as $root)
                                @include('public.about.partials.org-node', ['node' => $root])
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- ================= PROFIL TIM (SEARCH + FILTER) ================= --}}
            <div class="text-center wow fadeInUp mb-4" data-wow-delay="0.1s">
                <h3>Profil Pejabat &amp; Tim</h3>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3 wow fadeInUp" data-wow-delay="0.2s">
                <input type="text" id="orgSearchInput" class="form-control org-search-bar" placeholder="Cari nama atau jabatan...">
                <div id="orgFilterChips" class="text-md-end">
                    <span class="org-filter-chip active" data-unit="">Semua</span>
                    @foreach($daftarUnit as $u)
                        <span class="org-filter-chip" data-unit="{{ $u }}">{{ $u }}</span>
                    @endforeach
                </div>
            </div>

            <div class="row g-4" id="orgTeamGrid">
                @forelse($units as $unit)
                    <div class="col-lg-3 col-md-6 org-team-card wow fadeInUp" data-wow-delay="0.1s"
                         data-nama="{{ strtolower($unit->nama) }}" data-jabatan="{{ strtolower($unit->jabatan) }}" data-unit="{{ $unit->unit }}">
                        <div class="team-item bg-light rounded h-100">
                            <div class="text-center border-bottom p-4">
                                @if($unit->foto)
                                    <img class="img-fluid rounded-circle mb-4" src="{{ asset('storage/' . $unit->foto) }}" alt="{{ $unit->nama }}" style="width: 60%">
                                @else
                                    <div class="rounded-circle mb-4 mx-auto d-flex align-items-center justify-content-center bg-secondary bg-opacity-10" style="width: 60%; aspect-ratio: 1/1;">
                                        <span class="fs-3 fw-bold text-secondary">{{ strtoupper(substr($unit->nama, 0, 1)) }}</span>
                                    </div>
                                @endif
                                <h5>{{ $unit->nama }}</h5>
                                <span>{{ $unit->jabatan }}</span>
                                @if($unit->unit)
                                    <div><span>{{ $unit->unit }}</span></div>
                                @endif
                                @if($unit->deskripsi)
                                    <p class="mt-2 mb-0 small text-muted">{{ $unit->deskripsi }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-4">
                        Data profil belum tersedia.
                    </div>
                @endforelse
            </div>
            <div class="org-empty-state" id="orgEmptyState">Tidak ada data yang cocok dengan pencarian/filter.</div>
        </div>
    </div>
</main>
@include('layout.web.footer')

<script>
(function () {
    // Toggle expand/collapse pada bagan
    document.querySelectorAll('.org-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var node = btn.closest('.org-node');
            var children = node.querySelector(':scope > .org-children');
            if (!children) return;
            var collapsed = children.classList.toggle('collapsed');
            node.classList.toggle('collapsed-parent', collapsed);
            btn.innerHTML = collapsed ? '&plus;' : '&minus;';
        });
    });

    // Search + filter pada grid profil
    var searchInput = document.getElementById('orgSearchInput');
    var chips = document.querySelectorAll('.org-filter-chip');
    var cards = document.querySelectorAll('.org-team-card');
    var emptyState = document.getElementById('orgEmptyState');
    var activeUnit = '';

    function applyFilter() {
        var q = (searchInput.value || '').toLowerCase().trim();
        var visible = 0;
        cards.forEach(function (card) {
            var matchesText = !q || card.dataset.nama.includes(q) || card.dataset.jabatan.includes(q);
            var matchesUnit = !activeUnit || card.dataset.unit === activeUnit;
            var show = matchesText && matchesUnit;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        emptyState.style.display = visible === 0 ? 'block' : 'none';
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyFilter);
    }
    chips.forEach(function (chip) {
        chip.addEventListener('click', function () {
            chips.forEach(function (c) { c.classList.remove('active'); });
            chip.classList.add('active');
            activeUnit = chip.dataset.unit || '';
            applyFilter();
        });
    });
})();
</script>

@endsection
