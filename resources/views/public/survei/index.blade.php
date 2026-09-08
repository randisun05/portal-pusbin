@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.partial.notif')

<main>
@include('layout.web.header-detail')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3 py-5">

            @if($surveis->isEmpty())
                <p class="text-center text-muted">Survei belum tersedia saat ini.</p>
            @else
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center" width="10%">No</th>
                            <th scope="col" class="text-center">Nama Survei</th>
                            <th scope="col" class="text-center"></th>
                        </tr>
                    </thead>
                    @foreach ($surveis as $survei )
                        <tr>
                            <td class="text-center">{{$loop->iteration}}.</td>
                            <td>{{$survei->title}}</td>
                            <td class="text-center"><a href="/survei/{{$survei->id}}/create" class="badge bg-warning">Isi Survei</a></td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
</div>
</main>

@include('layout.web.footer')
@endsection
