@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Sertifikat Kegiatan</h1>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
             {{ session('success') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
             {{ session('error') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @unless($jfConfigured)
            <div class="alert alert-info">
                Endpoint Manajemen JF belum dikonfigurasi (<code>JF_MANAGEMENT_API_URL</code> kosong di <code>.env</code>).
                Data sertifikat tetap bisa diterbitkan, namun tombol "Kirim ke Manajemen JF" hanya akan menyiapkan payload tanpa benar-benar mengirim sampai endpoint tersedia.
            </div>
        @endunless

    <!-- Main Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <form class="row g-2" method="GET" action="/admin/sertifikat">
                <div class="col-auto">
                    <select name="kegiatan_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Pilih Kegiatan --</option>
                        @foreach ($kegiatans as $kegiatan)
                            <option value="{{ $kegiatan->id }}" {{ (string) $kegiatanId === (string) $kegiatan->id ? 'selected' : '' }}>{{ $kegiatan->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Instansi</th>
                            <th class="text-center">No. Sertifikat</th>
                            <th class="text-center">Status Kirim</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    @forelse ($absensis as $absensi)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $absensi->nama }}</td>
                            <td>{{ $absensi->nip }}</td>
                            <td>{{ $absensi->instansi }}</td>
                            <td class="text-center">{{ optional($absensi->sertifikat)->nomor_sertifikat ?? '-' }}</td>
                            <td class="text-center">
                                @if($absensi->sertifikat)
                                    @php
                                        $badge = match($absensi->sertifikat->status) {
                                            'terkirim' => 'bg-success',
                                            'gagal_kirim' => 'bg-warning',
                                            default => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ $absensi->sertifikat->status }}</span>
                                @else
                                    <span class="badge bg-light text-dark">Belum diterbitkan</span>
                                @endif
                            </td>
                            <td class="text-center text-nowrap">
                                @if(!$absensi->sertifikat)
                                    <form action="/admin/sertifikat/{{ $absensi->id }}/issue" method="POST" class="d-inline">
                                        @csrf
                                        <button class="badge bg-primary border-0">Terbitkan</button>
                                    </form>
                                @else
                                    <a href="/admin/sertifikat/{{ $absensi->sertifikat->id }}/cetak" class="badge bg-info" target="_blank">Pratinjau</a>
                                    <a href="/admin/sertifikat/{{ $absensi->sertifikat->id }}/download" class="badge bg-primary">Unduh PDF</a>
                                    <form action="/admin/sertifikat/{{ $absensi->sertifikat->id }}/send" method="POST" class="d-inline">
                                        @csrf
                                        <button class="badge bg-dark border-0">Kirim ke Manajemen JF</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                {{ $kegiatanId ? 'Belum ada data absensi untuk kegiatan ini.' : 'Pilih kegiatan terlebih dahulu.' }}
                            </td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
