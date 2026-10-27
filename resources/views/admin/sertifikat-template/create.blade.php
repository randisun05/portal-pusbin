@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Tambah Template Sertifikat</h1>

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <form action="/admin/sertifikat-template" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.sertifikat-template._form')
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
