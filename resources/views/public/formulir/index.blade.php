@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.partial.notif')

<main>
@include('layout.web.header-detail')

<section class="section">
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($formulirs->isEmpty())
                <p class="text-center text-muted">Belum ada formulir yang tersedia saat ini.</p>
            @else
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center" width="10%">No</th>
                            <th scope="col" class="text-center">Nama Formulir</th>
                            <th scope="col" class="text-center"></th>
                        </tr>
                    </thead>
                    @foreach ($formulirs as $formulir )
                        <tr>
                            <td class="text-center">{{$loop->iteration}}.</td>
                            <td>
                                {{$formulir->judul}}
                                @if($formulir->deskripsi)
                                    <span class="text-muted small d-block">{{ $formulir->deskripsi }}</span>
                                @endif
                            </td>
                            <td class="text-center"><a href="/form/{{$formulir->slug}}" class="badge bg-warning">Isi Formulir</a></td>
                        </tr>
                    @endforeach
                </table>
                <div class="d-flex justify-content-center">
                    {{ $formulirs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
</section>
</main>

@include('layout.web.footer')
@endsection
