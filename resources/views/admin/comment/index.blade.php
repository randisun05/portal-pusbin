@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Moderasi Komentar Publikasi</h1>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
             {{ session('success') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

    <!-- Main Content -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Publikasi</th>
                            <th class="text-center">Nama</th>
                            <th>Komentar</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    @forelse ($comments as $comment)
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>
                            @if($comment->post)
                                <a href="/publikasi/{{$comment->post->slug}}" target="_blank">{{ \Illuminate\Support\Str::limit($comment->post->title, 40) }}</a>
                            @else
                                <span class="text-muted">(publikasi dihapus)</span>
                            @endif
                        </td>
                        <td>{{$comment->nama}}</td>
                        <td>{{$comment->body}}</td>
                        <td class="text-center">
                            @if($comment->approved)
                                <span class="badge bg-success">Tampil</span>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @unless($comment->approved)
                                <form action="/admin/comment/{{$comment->id}}/approve" method="POST" class="d-inline">
                                    @csrf
                                    <button class="badge bg-success border-0">Setujui</button>
                                </form>
                            @endunless
                            <form action="/admin/comment/{{$comment->id}}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Lanjutkan Untuk Menghapus Data')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada komentar.</td>
                    </tr>
                    @endforelse
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
