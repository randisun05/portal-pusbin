<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Style untuk merapikan struktur email di tengah */
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            text-align: left;
            font-family: Arial, sans-serif;
        }
        .message {
            margin-bottom: 20px;
        }
        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo-container img {
            width: 50%;
        }
        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 20px auto;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- <div class="logo-container">
            <a class="navbar-brand" href="index.html">
               <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
            </a>
        </div> --}}
        <hr>
        <div class="message">
            <p>Dear <strong>{{ $data['nama'] }}</strong>,</p>
            <p>Pendaftaran konsultasi anda telah kami terima.</p>
            <p>Silakan hadir pada:</p>
                <ul>
                    <li>Tanggal/Dimulai Jam : {{ $data->kegiatan['waktu'] }} WIB</li>
                    <li>Link Zoom : {{ $data->kegiatan['link'] }}</li>
                    <li>Format Nama Zoom : {{ $data['nama'] }} | {{ $data['instansi'] }}</li>
                </ul>

            <p>Demikian informasi dari kami.</p>
            <p>Terimakasih,</p>
            <p>Pusat Pembinaan Jabatan Fungsional Kepegawaian</p>
        </div>
    </div>
</body>
</html>
