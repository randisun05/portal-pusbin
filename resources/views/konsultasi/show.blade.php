@extends('layout.main-main')
@section('container')
@include('layout.partial.header-componen')

<!-- Form Show Konsultasi -->

@if ($konsultasi != null)
    @if ($konsultasi->jawab == 1)
    <div class="container-fluid mt-4">
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
    <div class="">
        <p class="text-center fs-4 padingfooter">Tiket Belum Dijawab</p>
    </div>
    @endif
    @else
<p class="text-center fs-4 padingfooter">Tiket Usul Tidak Tersedia</p>
@endif

                <div class="text-center mb-0">
                    <a href="/konsultasi/cari"><u>Kembali </u></a>
                </div>
<div class="padingfooter">
@include('layout.partial.footer')
</div>

@endsection
