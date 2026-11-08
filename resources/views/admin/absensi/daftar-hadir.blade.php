<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Hadir</title>
    <style>
        @page { margin: 24px; }
        body { margin: 0; font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #14172b; }
        .header { text-align: center; margin-bottom: 16px; }
        .header h1 { font-size: 18px; margin: 0 0 4px; }
        .header .sub { color: #6c7382; font-size: 11px; }
        .meta { margin-bottom: 14px; font-size: 12px; }
        .meta strong { display: inline-block; width: 130px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #444; padding: 6px 8px; font-size: 11px; }
        th { background: #eceff3; text-align: center; }
        td.center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daftar Hadir Kegiatan</h1>
        <div class="sub">Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara - Badan Kepegawaian Negara</div>
    </div>

    <div class="meta">
        <div><strong>Nama Kegiatan</strong>: {{ optional($kegiatan)->nama ?? 'Semua Kegiatan' }}</div>
        <div><strong>Waktu Pelaksanaan</strong>: {{ optional($kegiatan)->waktu ?? '-' }}</div>
        <div><strong>Jumlah Peserta</strong>: {{ $absensis->count() }} orang</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 16%;">NIP</th>
                <th style="width: 20%;">Nama</th>
                <th style="width: 16%;">Jabatan</th>
                <th style="width: 18%;">Instansi</th>
                <th style="width: 26%;">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($absensis as $absensi)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ $absensi->nip }}</td>
                    <td>{{ $absensi->nama }}</td>
                    <td>{{ $absensi->jabatan }}</td>
                    <td>{{ $absensi->instansi }}</td>
                    <td></td>
                </tr>
            @empty
                <tr>
                    <td class="center" colspan="6">Belum ada data absensi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
