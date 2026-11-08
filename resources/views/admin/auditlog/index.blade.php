@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Audit Trail</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <form class="row g-2" method="GET" action="/admin/auditlog">
                <div class="col-auto">
                    <select name="action" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Aksi</option>
                        @foreach ($actions as $action)
                            <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>{{ ucfirst($action) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <input type="text" name="user_name" class="form-control" placeholder="Cari nama pengguna..." value="{{ request('user_name') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="/admin/auditlog" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">Waktu</th>
                            <th class="text-center">Pengguna</th>
                            <th class="text-center">Aksi</th>
                            <th>Deskripsi</th>
                            <th class="text-center">IP</th>
                        </tr>
                    </thead>
                    @forelse ($logs as $log)
                    <tr>
                        <td class="text-center text-nowrap">{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $log->user_name }}</td>
                        <td class="text-center">
                            @php
                                $badge = match(true) {
                                    str_contains($log->action, 'delete') => 'bg-danger',
                                    str_contains($log->action, 'update') => 'bg-warning',
                                    str_contains($log->action, 'created') => 'bg-success',
                                    str_contains($log->action, 'login-failed') => 'bg-danger',
                                    str_contains($log->action, 'login') => 'bg-info',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ $log->action }}</span>
                        </td>
                        <td>
                            {{ $log->description }}
                            @if($log->changes)
                                <details class="mt-1">
                                    <summary class="text-muted small">Detail perubahan</summary>
                                    <pre class="small bg-light p-2 mb-0">{{ json_encode(json_decode($log->changes), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </details>
                            @endif
                        </td>
                        <td class="text-center">{{ $log->ip_address }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada aktivitas tercatat.</td>
                    </tr>
                    @endforelse
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
