@extends('layout.main-main')
@section('container')
@include('layout.partial.header-componen')

<!-- Form Usulan Konsultasi -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Nama Kegiatan</th>
                                                <th class="text-center">Instansi</th>
                                                <th class="text-center">Action</th>

                                            </tr>
                                        </thead>
                                        @foreach ($kegiatans as $kegiatan )
                                        @if ($kegiatan->id != 1)
                                        <tr>
                                            <td>{{$kegiatan->nama}}</td>
                                            <td>{{$kegiatan->instansi}}</td>
                                            <td class="text-center"><a href="/absensi/{{$kegiatan->slug}}"><button class="btn btn-primary" >Absensi</button> </a>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


<div class="padingfooter">
@include('layout.partial.footer')
</div>
@endsection
