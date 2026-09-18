@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')

<style>
    .pk-meta { display: flex; gap: 18px; flex-wrap: wrap; color: var(--default-color); font-size: .9rem; margin-bottom: 20px; }
    .pk-share a { display: inline-flex; width: 36px; height: 36px; border-radius: 50%; align-items: center; justify-content: center; margin-right: 6px; color: #fff; }
    .pk-share .wa { background: #25D366; }
    .pk-share .fb { background: #1877F2; }
    .pk-share .tw { background: #1DA1F2; }
    .pk-share .copy { background: var(--default-color); cursor: pointer; border: 0; }
    .pk-reactions button { border: 1px solid color-mix(in srgb, var(--default-color), transparent 90%); background: #fff; border-radius: 20px; padding: 6px 16px; margin-right: 8px; font-size: .88rem; cursor: pointer; transition: all .15s; }
    .pk-reactions button.active, .pk-reactions button:hover { background: color-mix(in srgb, var(--accent-color), transparent 90%); border-color: var(--accent-color); color: var(--accent-color); }
    .pk-comment-item { border-bottom: 1px solid color-mix(in srgb, var(--default-color), transparent 90%); padding: 14px 0; }
    .pk-related-card { border: 1px solid color-mix(in srgb, var(--default-color), transparent 90%); border-radius: 12px; overflow: hidden; height: 100%; }
    .pk-related-card img { width: 100%; height: 140px; object-fit: cover; }
    .pk-post-image { max-width: 50%; }
    @media (max-width: 767.98px) { .pk-post-image { max-width: 100%; } }
</style>

<!-- Main Content -->
<main>
    <section class="section">
        <div class="container">
            <h1>{{$post->title}}</h1>
            <div class="pk-meta">
                <span><i class="bi bi-person me-2"></i>{{ $post->author->name }}</span>
                <span><i class="bi bi-calendar-event me-2"></i>{{ $post->publish_at }}</span>
                <span><i class="bi bi-eye me-2"></i>{{ number_format($post->views) }} dilihat</span>
            </div>
            @if($post->image)
                <div class="text-center">
                    <img src="{{asset('storage/' . $post->image)}}" class="img-fluid pk-post-image rounded">
                </div>
                <br>
            @endif
            <div class="prose-content">
                {!! $post->body !!}
                @if($post->document)
                <div class="mt-3">
                    Unduh Dokumen {{$post->namadocument}} <a href="/storage/{{ $post->document }}" download="{{$post->namadocument}}">Disini</a>
                </div>
                @endif
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top">
                <div class="pk-reactions mb-2" id="pkReactions" data-url="/publikasi/{{ $post->slug }}/react">
                    @foreach (\App\Models\Reaction::TYPES as $type)
                        <button type="button" class="pk-reaction-btn {{ $myReaction === $type ? 'active' : '' }}" data-type="{{ $type }}">
                            {{ ucfirst($type) }} <span class="count">{{ $reactionCounts[$type] ?? 0 }}</span>
                        </button>
                    @endforeach
                </div>
                <div class="pk-share mb-2">
                    <a class="wa" target="_blank" href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url()->current()) }}"><i class="bi bi-whatsapp"></i></a>
                    <a class="fb" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"><i class="bi bi-facebook"></i></a>
                    <a class="tw" target="_blank" href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}"><i class="bi bi-twitter-x"></i></a>
                    <button type="button" class="copy" id="pkCopyLink" title="Salin Tautan"><i class="bi bi-link-45deg"></i></button>
                </div>
            </div>

            @if($related->isNotEmpty())
                <div class="mt-5">
                    <h4 class="mb-3">Publikasi Terkait</h4>
                    <div class="row g-3">
                        @foreach ($related as $r)
                            @php
                                $relatedImg = $r->image ? asset('storage/' . $r->image) : asset('assets-flexor/img/blog/blog-' . ((($loop->index % 5)) + 1) . '.jpg');
                            @endphp
                            <div class="col-md-4">
                                <a href="/publikasi/{{ $r->slug }}" class="text-decoration-none text-dark">
                                    <div class="pk-related-card">
                                        <img src="{{ $relatedImg }}" alt="{{ $r->title }}">
                                        <div class="p-3">
                                            <h6 class="mb-0">{{ \Illuminate\Support\Str::limit($r->title, 60) }}</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-5" id="komentar">
                <h4 class="mb-3">Komentar ({{ $comments->count() }})</h4>

                @if (session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @forelse ($comments as $comment)
                    <div class="pk-comment-item">
                        <strong>{{ $comment->nama }}</strong>
                        <span class="text-muted small ms-2">{{ $comment->created_at->diffForHumans() }}</span>
                        <p class="mb-0 mt-1">{{ $comment->body }}</p>
                    </div>
                @empty
                    <p class="text-muted">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                @endforelse

                <form action="/publikasi/{{ $post->slug }}/komentar" method="POST" class="mt-4">
                    @csrf
                    @include('layout.partial.honeypot')
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Anda" value="{{ old('nama') }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email (opsional)" value="{{ old('email') }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="3" placeholder="Tulis komentar Anda..." required>{{ old('body') }}</textarea>
                            @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="/webpusbin" class="btn btn-outline-secondary me-2">Kembali</a>
            <a href="/publikasi" class="btn btn-outline-secondary">Daftar Publikasi</a>
        </div>
    </section>
</main>


<!-- End Of Main Content -->

@include('layout.web.footer')

<script>
(function () {
    var reactionsBox = document.getElementById('pkReactions');
    if (reactionsBox) {
        var url = reactionsBox.dataset.url;
        reactionsBox.querySelectorAll('.pk-reaction-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ type: btn.dataset.type }),
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    reactionsBox.querySelectorAll('.pk-reaction-btn').forEach(function (b) {
                        b.classList.remove('active');
                        var count = data.counts[b.dataset.type] || 0;
                        b.querySelector('.count').textContent = count;
                    });
                    btn.classList.add('active');
                })
                .catch(function () {});
            });
        });
    }

    var copyBtn = document.getElementById('pkCopyLink');
    if (copyBtn) {
        copyBtn.addEventListener('click', function () {
            navigator.clipboard.writeText(window.location.href).then(function () {
                copyBtn.innerHTML = '<i class="bi bi-check-lg"></i>';
                setTimeout(function () { copyBtn.innerHTML = '<i class="bi bi-link-45deg"></i>'; }, 1500);
            });
        });
    }
})();
</script>

@endsection
