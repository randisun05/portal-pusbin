<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat {{ $sertifikat->nomor_sertifikat }}</title>
    <style>
        @page { margin: 0; }
        body { margin: 0; font-family: 'Helvetica', 'Arial', sans-serif; }
        .cert { border: 14px solid #f92c24; padding: 50px; text-align: center; margin: 20px; }
        .cert h1 { font-size: 32px; color: #f92c24; letter-spacing: 4px; margin-bottom: 0; }
        .cert .sub { color: #6c7382; font-size: 13px; margin-top: 6px; margin-bottom: 30px; }
        .cert .nama { font-size: 26px; font-weight: bold; margin: 20px 0; padding-bottom: 8px; border-bottom: 2px solid #f92c24; display: inline-block; }
        .cert .keterangan { font-size: 14px; line-height: 1.8; width: 70%; margin: 0 auto 30px; }
        .cert .nomor { margin-top: 40px; font-size: 11px; color: #6c7382; }
    </style>
</head>
<body>
    <div class="cert">
        <h1>SERTIFIKAT</h1>
        <div class="sub">Pusat Pembinaan Jabatan Fungsional Kepegawaian - Badan Kepegawaian Negara</div>
        <p>Diberikan kepada:</p>
        <div class="nama">{{ $sertifikat->absensi->nama }}</div>
        <p class="keterangan">
            NIP {{ $sertifikat->absensi->nip }}, {{ $sertifikat->absensi->jabatan }} dari {{ $sertifikat->absensi->instansi }},
            atas partisipasinya dalam kegiatan
            <strong>{{ optional($sertifikat->absensi->kegiatan)->nama }}</strong>
            yang diselenggarakan pada {{ optional($sertifikat->absensi->kegiatan)->waktu }}.
        </p>
        <div class="nomor">Nomor Sertifikat: {{ $sertifikat->nomor_sertifikat }}</div>
    </div>
</body>
</html>
