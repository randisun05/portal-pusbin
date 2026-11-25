<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container { max-width: 600px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif; }
        .message { margin-bottom: 20px; }
        hr { border: none; border-top: 1px solid #ccc; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <hr>
        <div class="message">
            <p>Dear <strong>{{ $data->nama }}</strong>,</p>
            <p>Pendaftaran Anda pada kegiatan berikut telah kami terima:</p>
            <ul>
                <li>Nama Kegiatan : {{ $data->kegiatan->nama }}</li>
                <li>Waktu Pelaksanaan : {{ $data->kegiatan->waktu }} WIB</li>
                @if($data->kegiatan->link)
                    <li>Link/Informasi : {{ $data->kegiatan->link }}</li>
                @endif
                <li>Instansi : {{ $data->instansi }}</li>
            </ul>
            <p>Mohon simpan email ini sebagai bukti pendaftaran Anda.</p>
            <p>Terima kasih,</p>
            <p>Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara</p>
        </div>
    </div>
</body>
</html>
