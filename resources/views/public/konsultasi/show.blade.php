@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')
@include('layout.partial.notif')


<!-- Form Show Konsultasi -->
<main>
<section class="section">
@if ($konsultasi != null)
    @if ($konsultasi->jawab == 1)
    <div class="container">
        <div class="col-md-6 offset-md-3 card">
            <div class="card-header">
            <h5 class="mb-0">Jadwal Konsultasi</h5>
            </div>
            <form>
                    <div class="row mb-3 mt-3">
                        <label class="row row col-4 ms-4" for="basic-default-name">NIP Pengusul</label>
                        <div class="col-md-6 ">
                          <label>: {{$konsultasi->nip}}</label>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="row row col-4 ms-4" for="basic-default-company">Perihal Konsultasi</label>
                        <div class="col-md-6 ">
                            <label>: {{$konsultasi->perihal}}</label>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="row row col-4 ms-4" for="basic-default-email">Jadwal Konsultasi</label>
                        <div class="col-md-6 ">
                          <label>: {{$konsultasi->jadwalfix}}</label>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="row row col-4 ms-4" for="basic-default-email">Link Konsultasi</label>
                        <div class="col-md-6 ">
                          <label>: {{$konsultasi->link}}</label>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="row row col-4 ms-4" for="basic-default-phone">Person In Charge</label>
                        <div class="col-md-6">
                          <label name="pic">: {{$konsultasi->pic}}</label>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="row row col-4 ms-4" for="basic-default-message">Keterangan</label>
                        <div class="col-md-6">
                          <label>:{{$konsultasi->keterangan}}</label>
                        </div>
                      </div>
            </form>
        </div>
    </div>
    @elseif ($konsultasi->jawab == 0)
    <div class="container">
        <p class="text-center fs-4">Tiket Belum Dijawab</p>
    </div>
    @endif
    @else
<div class="container">
    <p class="text-center fs-4">Tiket Usul Tidak Tersedia</p>
</div>
@endif

                <div class="text-center mt-4">
                    <a href="/konsultasi/cari" class="btn btn-outline-secondary">Kembali</a>
                </div>
</section>
</main>
@include('layout.web.footer')

@endsection
