<!DOCTYPE html>
<html>
<head>
    <title>Tiket Konsultasi Direktorat JF MASN</title>
</head>
<body>
<h3> Dear {{ $data['nip'] }}</h3>

<p>Usul konsultasi anda telah dikirim ke Sistem informasi Jabatan Fungsional Kepegawaian Badan Kepegawaian Negara dengan nomor tiket <strong>{{ $data['tiket'] }}</strong>.</p>
<p>Kami akan segera menindaklanjuti usulan Anda.</p>

<div class="mb-0">Anda dapat memantau progres usul konsultasi secara online melalui link berikut:</div>
<strong><a href="{{ url('/konsultasi/tiket') }}">{{ url('/konsultasi/tiket') }}</a></strong>
<p>
<div class="mb-0">Regards,</div>
<div class="mb-0">Direktorat Jabatan Fungsional Manajemen Aparatur Sipil Negara</div>
<div class="mb-0"><strong>Badan Kepegawaian Negara</strong></div>

</body>
</html>