@extends('layout.main-admin')

@section('container')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Survei</h1>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <a href="/admin/survei" class="btn btn-primary ms-2">Kembali</a>
            <hr>
                <div class="form-group mt-4 ms-5">
                    <div class="row row-cols-3 mb-4">
                        <div class="col col-lg-2"><label for="nama">Nama Survei</label></div>
                        <div class="col"> <input type="text" class="form-control" name="title" id="title" value="{{old('title', $data->title)}}" disabled></div>
                        <div class="col col-lg-2"><label for="nama">Tipe Penilaian</label></div>
                        <div class="col">
                            <input type="text" class="form-control" name="title" id="title" value="{{ old('type', 
                                $data->type === 1 ? 'Teks' : 
                                ($data->type === 2 ? 'Ya/Tidak' : 
                                ($data->type === 3 ? 'Skala Tiga' : 
                                ($data->type === 4 ? 'Skala Likert' : 
                                ($data->type === 5 ? 'Skala Lima' : ''))))
                            ) }}" disabled>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-body">
        <a href="/admin/survei/{{ $data->id }}/create" class="btn btn-primary ms-2">Tambah Indikator</a>
            <hr>
       
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center">Indikator</th>
                            <th class="text-center" width="10%">Action</th>
                        </tr>
                    </thead>
                    @foreach ($indikators as $indikator )
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>{{$indikator->indikator->title}}</td>
                        <td class="text-center">    <form action="/admin/survei/{{$indikator->id}}/delete" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Lanjutkan Untuk Menghapus Data')"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg></button> </td>
                            </form>
                    </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                           <th class="text-center">No</th>
                            <th class="text-center">Indikator</th>
                            <th class="text-center" width="10%">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

</div>

<!-- End of Main Content -->

@endsection
