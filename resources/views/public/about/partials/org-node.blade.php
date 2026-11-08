@php
    $hasChildren = $node->children->count() > 0;
@endphp
<li class="org-node {{ $hasChildren ? 'has-children' : '' }}">
    <div class="org-card">
        @if($hasChildren)
            <button type="button" class="org-toggle" aria-label="Tampilkan/Sembunyikan Bawahan">&minus;</button>
        @endif
        <div class="org-photo">
            @if($node->foto)
                <img src="{{ asset('storage/' . $node->foto) }}" alt="{{ $node->nama }}">
            @else
                <span class="org-photo-fallback">{{ strtoupper(substr($node->nama, 0, 1)) }}</span>
            @endif
        </div>
        <h6 class="org-nama">{{ $node->nama }}</h6>
        <span class="org-jabatan">{{ $node->jabatan }}</span>
        @if($node->unit)
            <span class="org-unit badge">{{ $node->unit }}</span>
        @endif
    </div>

    @if($hasChildren)
        <ul class="org-children">
            @foreach($node->children as $child)
                @include('public.about.partials.org-node', ['node' => $child])
            @endforeach
        </ul>
    @endif
</li>
