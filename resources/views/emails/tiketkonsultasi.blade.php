<!DOCTYPE html>
<html>
<head>
    <title>Tiket Konsultasi Jabatan Fungsional Kepegawaian</title>
</head>
<body>
<h3> Dear {{ $data['nip'] }}</h3>

<p>Usul konsultasi anda telah dikirim ke Sistem informasi Jabatan Fungsional Kepegawaian Badan Kepegawaian Negara dengan nomor tiket <strong>{{ $data['tiket'] }}</strong>.</p>
<p>Kami akan segera menindaklanjuti usulan Anda.</p>

<div class="mb-0">Anda dapat memantau progres usul konsultasi secara online melalui link berikut:</div>
<strong>www.pusbin.com/cektiket</strong>
<p>
<div class="mb-0">Regards,</div>
<div class="mb-0">Pusat Pembinaan Jabatan Fungsional Kepegawaian</div>
<div class="mb-0"><strong>Badan Kepegawaian Negara</strong></div>

</body>
</html>