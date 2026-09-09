<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat {{ $sertifikat->nomor_sertifikat }}</title>
    <style>
        @page { size: landscape; margin: 0; }
        body { margin: 0; font-family: 'Georgia', serif; background: #f0f0f0; }
        .cert { width: 1000px; max-width: 100%; margin: 30px auto; background: #fff; padding: 60px; border: 12px solid #f92c24; box-sizing: border-box; text-align: center; }
        .cert h1 { font-size: 2.2rem; color: #f92c24; margin-bottom: 0; letter-spacing: 2px; }
        .cert .sub { color: #6c7382; margin-top: 4px; margin-bottom: 30px; }
        .cert .nama { font-size: 2rem; font-weight: bold; margin: 20px 0; border-bottom: 2px solid #f92c24; display: inline-block; padding-bottom: 8px; }
        .cert .keterangan { font-size: 1.05rem; line-height: 1.8; max-width: 700px; margin: 0 auto 30px; }
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
        <h1>SERTIFIKAT</h1>
        <div class="sub">Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara - Badan Kepegawaian Negara</div>
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
