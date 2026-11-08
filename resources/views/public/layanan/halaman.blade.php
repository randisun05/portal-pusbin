@extends('layout.main-main')
@section('container')
@include('layout.web.nav')

<main>
    @include('layout.web.header-detail')

    <section class="section">
        <div class="container prose-content">
            {!! $halaman->konten !!}
        </div>
    </section>
</main>

@include('layout.web.footer')
@endsection
