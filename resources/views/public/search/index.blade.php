@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
@include('layout.web.header-detail')

<div class="container-fluid">
    <div class="row py-5">
        <div class="col-md-8 offset-md-2 py-2">
            <form class="mb-4" action="/cari" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="q" placeholder="Cari publikasi, FAQ, layanan, repository.." value="{{ $q }}" required>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>

            @if ($q !== '')
                <p class="text-muted">
                    Ditemukan <strong>{{ $total }}</strong> hasil untuk pencarian "<strong>{{ $q }}</strong>"
                </p>

                @if ($total === 0)
                    <div class="alert alert-warning">Tidak ada hasil yang cocok. Coba kata kunci lain.</div>
                @endif

                @if ($posts->isNotEmpty())
                    <h5 class="mt-4 mb-2">Publikasi</h5>
                    <ul class="list-group mb-3">
                        @foreach ($posts as $post)
                            <li class="list-group-item">
                                <a href="/publikasi/{{ $post->slug }}">{{ $post->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($faqs->isNotEmpty())
                    <h5 class="mt-4 mb-2">FAQ</h5>
                    <ul class="list-group mb-3">
                        @foreach ($faqs as $faq)
                            <li class="list-group-item">
                                <a href="/faq">{{ $faq->pertanyaan }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($layanans->isNotEmpty())
                    <h5 class="mt-4 mb-2">Layanan</h5>
                    <ul class="list-group mb-3">
                        @foreach ($layanans as $layanan)
                            <li class="list-group-item">
                                <a href="{{ $layanan->link }}">{{ $layanan->nama }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($repositories->isNotEmpty())
                    <h5 class="mt-4 mb-2">Repository</h5>
                    <ul class="list-group mb-3">
                        @foreach ($repositories as $repo)
                            <li class="list-group-item">
                                <a href="/repository">{{ $repo->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endif
        </div>
    </div>
</div>
</main>

@include('layout.web.footer')
@endsection
