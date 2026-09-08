@extends('layout.main-admin')

@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Form Ubah Admin</h1>
    @if (session()->has('success'))
<div class="alert alert-success col-lg-8" role="alert">
{{session('success')}}
</div>
@endif

    <!-- Main Content -->
    <div class="card shadow">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <main class="form-registration w-100 m-auto">
                        <form action="/admin/register/{{ $user->id }}" method="POST">
                            @method('put')
                            @csrf
                          <div class="form-floating">
                            <input type="text" name="name" class="form-control rounded-top @error('name') is-invalid @enderror" id="name" placeholder="name" value="{{old('name', $user->name)}}">
                            <label for="name">Name</label>

                            @error('name')
                            <div class="invalid-feedback">
                                Masukan Nama
                            </div>
                            @enderror

                          </div>
                          <div class="form-floating">
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="username" value="{{old('username', $user->username)}}">
                            <label for="username">User Name</label>
                            @error('username')
                            <div class="invalid-feedback">
                                Masukan Username
                            </div>
                            @enderror
                          </div>
                          <div class="form-floating">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="email" value="{{ old('email', $user->email)}}">
                            <label for="email">email</label>
                            @error('email')
                            <div class="invalid-feedback">
                                Masukan Email
                            </div>
                            @enderror
                          </div>
                          <div class="form-floating">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                            <label for="password">Password Baru (kosongkan jika tidak diubah)</label>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                          </div>
                          <div class="form-floating">
                            <select name="role_id" class="form-select rounded-bottom @error('role_id') is-invalid @enderror" id="role_id">
                                <option value="">-- Tanpa Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->label }}</option>
                                @endforeach
                            </select>
                            <label for="role_id">Role</label>
                            @error('role_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                          </div>
                          <div class="text-center">
                          <button class="btn btn-lg btn-primary mt-3" type="submit">Simpan</button>
                          </div>
                        </form>
                      </main>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->

@endsection
