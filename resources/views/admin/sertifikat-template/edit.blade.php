@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Ubah Template Sertifikat</h1>

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <form action="/admin/sertifikat-template/{{ $template->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                @include('admin.sertifikat-template._form')
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
