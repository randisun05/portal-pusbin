@extends('layout.main-admin')

@section('container')

<div class="container-fluid">
    <h1 class="h3 mb-2 mt-5 text-center">Submission — {{ $formulir->judul }}</h1>

    <div class="card shadow">
        <div class="card-header py-3 mt-2 d-flex justify-content-between align-items-center">
            <a href="/admin/formulir/{{ $formulir->id }}/field" class="btn btn-outline-secondary">Kelola Field</a>
            <a href="/admin/formulir/{{ $formulir->id }}/export" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
        <div class="card-body">
            @if ($fields->isEmpty())
                <p class="text-muted mb-0">Formulir ini belum punya field, jadi belum ada data untuk ditampilkan.</p>
            @elseif ($submissions->isEmpty())
                <p class="text-muted mb-0">Belum ada submission masuk.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                @foreach ($fields as $field)
                                    <th class="text-center">{{ $field->label }}</th>
                                @endforeach
                                <th class="text-center">Tanggal Isi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($submissions as $submission)
                            <tr>
                                <td class="text-center">{{ $loop->iteration + ($submissions->currentPage() - 1) * $submissions->perPage() }}</td>
                                @foreach ($fields as $field)
                                    <td>
                                        @if ($field->tipe === 'file')
                                            @php $lampiran = $submission->lampiranUntuk($field); @endphp
                                            @if ($lampiran)
                                                <a href="{{ asset('storage/' . $lampiran->path) }}" target="_blank">
                                                    <i class="fas fa-paperclip"></i> {{ $lampiran->nama_asli }}
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        @else
                                            @php $jawaban = $submission->jawabanUntuk($field); @endphp
                                            {{ is_array($jawaban) ? implode(', ', $jawaban) : ($jawaban ?? '-') }}
                                        @endif
                                    </td>
                                @endforeach
                                <td class="text-center">{{ $submission->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
