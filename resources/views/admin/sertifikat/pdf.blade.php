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
        @page { margin: 0; }
        body { margin: 0; font-family: 'Helvetica', 'Arial', sans-serif; }
        .cert { border: 14px solid {{ $aksen }}; padding: 50px; text-align: center; margin: 20px; }
        .cert .logo { height: 60px; margin-bottom: 14px; }
        .cert h1 { font-size: 32px; color: {{ $aksen }}; letter-spacing: 4px; margin-bottom: 0; }
        .cert .sub { color: #6c7382; font-size: 13px; margin-top: 6px; margin-bottom: 30px; }
        .cert .nama { font-size: 26px; font-weight: bold; margin: 20px 0; padding-bottom: 8px; border-bottom: 2px solid {{ $aksen }}; display: inline-block; }
        .cert .keterangan { font-size: 14px; line-height: 1.8; width: 70%; margin: 0 auto 30px; }
        .cert .ttd { margin-top: 30px; }
        .cert .ttd img { height: 60px; }
        .cert .ttd .nama-ttd { font-weight: bold; text-decoration: underline; margin-top: 4px; }
        .cert .ttd .jabatan-ttd { font-size: 12px; color: #6c7382; }
        .cert .nomor { margin-top: 40px; font-size: 11px; color: #6c7382; }
    </style>
</head>
<body>
    <div class="cert">
        @if($template && $template->logo)
            <img src="{{ storage_path('app/public/' . $template->logo) }}" alt="Logo" class="logo">
        @endif
        <h1>SERTIFIKAT</h1>
        <div class="sub">Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara - Badan Kepegawaian Negara</div>
        <p>{{ $tekspembuka }}</p>
        <div class="nama">{{ $sertifikat->absensi->nama }}</div>
        <p class="keterangan">{!! $keterangan !!}</p>

        @if($template && ($template->nama_penandatangan || $template->tanda_tangan))
            <div class="ttd">
                @if($template->tanda_tangan)
                    <img src="{{ storage_path('app/public/' . $template->tanda_tangan) }}" alt="Tanda Tangan">
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
