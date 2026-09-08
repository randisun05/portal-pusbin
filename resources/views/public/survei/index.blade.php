@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.partial.notif')

<main>
@include('layout.web.header-detail')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3 py-5">

            @if (session()->has('success'))
                <div class="text-center mb-4 p-4" style="background: linear-gradient(135deg, #fdeceb, #f7f8fb); border-radius: 16px;">
                    <div style="font-size: 3rem;">{{ session('badgeIcon', '🏆') }}</div>
                    <h4 class="mt-2 mb-1">Terima kasih atas kontribusi Anda!</h4>
                    <p class="text-muted mb-2">{{ session('success') }}</p>
                    @if (session()->has('badgeLabel'))
                        <span class="badge rounded-pill" style="background:#f92c24; padding: 8px 18px; font-size: .85rem;">
                            {{ session('badgeLabel') }} &middot; {{ session('jumlahSurveiSelesai') }} survei diisi
                        </span>
                    @endif
                </div>
            @endif

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
