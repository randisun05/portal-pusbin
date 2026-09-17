<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat {{ $sertifikat->nomor_sertifikat }}</title>
    @php
        $template = $sertifikat->template;
        $aksen = $template->warna_aksen ?? '#f92c24';
        $tekspembuka = $template->teks_pembuka ?? 'Diberikan kepada:';
        $keterangan = $template
            ? $template->renderKeterangan($sertifikat->absensi)
            : 'NIP ' . $sertifikat->absensi->nip . ', ' . $sertifikat->absensi->jabatan . ' dari ' . $sertifikat->absensi->instansi . ', atas partisipasinya dalam kegiatan ' . optional($sertifikat->absensi->kegiatan)->nama . ' yang diselenggarakan pada ' . optional($sertifikat->absensi->kegiatan)->waktu . '.';
    @endphp
    <style>
        @page { size: landscape; margin: 0; }
        body { margin: 0; font-family: 'Georgia', serif; background: #f0f0f0; }
        .cert { width: 1000px; max-width: 100%; margin: 30px auto; background: #fff; padding: 60px; border: 12px solid {{ $aksen }}; box-sizing: border-box; text-align: center; }
        .cert .logo { height: 70px; margin-bottom: 14px; }
        .cert h1 { font-size: 2.2rem; color: {{ $aksen }}; margin-bottom: 0; letter-spacing: 2px; }
        .cert .sub { color: #6c7382; margin-top: 4px; margin-bottom: 30px; }
        .cert .nama { font-size: 2rem; font-weight: bold; margin: 20px 0; border-bottom: 2px solid {{ $aksen }}; display: inline-block; padding-bottom: 8px; }
        .cert .keterangan { font-size: 1.05rem; line-height: 1.8; max-width: 700px; margin: 0 auto 30px; }
        .cert .ttd { margin-top: 30px; }
        .cert .ttd img { height: 70px; }
        .cert .ttd .nama-ttd { font-weight: bold; text-decoration: underline; margin-top: 4px; }
        .cert .ttd .jabatan-ttd { font-size: .85rem; color: #6c7382; }
        .cert .nomor { margin-top: 40px; font-size: .9rem; color: #6c7382; }
        .no-print { text-align: center; margin: 16px; }
        @media print { .no-print { display: none; } body { background: #fff; } .cert { margin: 0; border-width: 8px; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()">Cetak / Simpan sebagai PDF</button>
    </div>
    <div class="cert">
        @if($template && $template->logo)
            <img src="{{ asset('storage/' . $template->logo) }}" alt="Logo" class="logo">
        @endif
        <h1>SERTIFIKAT</h1>
        <div class="sub">Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara - Badan Kepegawaian Negara</div>
        <p>{{ $tekspembuka }}</p>
        <div class="nama">{{ $sertifikat->absensi->nama }}</div>
        <p class="keterangan">{!! $keterangan !!}</p>

        @if($template && ($template->nama_penandatangan || $template->tanda_tangan))
            <div class="ttd">
                @if($template->tanda_tangan)
                    <img src="{{ asset('storage/' . $template->tanda_tangan) }}" alt="Tanda Tangan">
                @endif
                @if($template->nama_penandatangan)
                    <div class="nama-ttd">{{ $template->nama_penandatangan }}</div>
                @endif
                @if($template->jabatan_penandatangan)
                    <div class="jabatan-ttd">{{ $template->jabatan_penandatangan }}</div>
                @endif
            </div>
        @endif

        <div class="nomor">Nomor Sertifikat: {{ $sertifikat->nomor_sertifikat }}</div>
        <img src="{{ $qrCode }}" alt="QR Verifikasi" style="width: 90px; height: 90px; margin-top: 10px;">
        <div class="nomor">Pindai untuk verifikasi keaslian sertifikat</div>
    </div>
</body>
</html>
