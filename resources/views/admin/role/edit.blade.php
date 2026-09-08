@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Atur Permission: {{ $role->label }}</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="/admin/role/{{ $role->id }}" method="POST">
                @method('put')
                @csrf

                @foreach ($permissionGroups as $grup => $items)
                    <h6 class="mt-4 mb-2">{{ $grup }}</h6>
                    <div class="row">
                        @foreach ($items as $slug => $label)
                            @php $permission = \App\Models\Permission::where('slug', $slug)->first(); @endphp
                            @if($permission)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm{{ $permission->id }}"
                                            {{ in_array($permission->id, $currentPermissionIds) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm{{ $permission->id }}">
                                            {{ $label }}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach

                <div class="text-center mt-4">
                    <button class="btn btn-lg btn-primary" type="submit">Simpan Permission</button>
                    <a href="/admin/role" class="btn btn-lg btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
