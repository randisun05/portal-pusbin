@extends('login.layout')

@section('badge')
    <span class="login-badge"><i class="bi bi-person-lock"></i> Login Manual</span>
@endsection

@section('heading', 'Login Admin')
@section('subheading', 'Masuk dengan email dan password akun admin.')

@section('form')
<form action="/login" method="post">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="email@contoh.go.id" value="{{ old('email') }}" required autofocus>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <div class="password-wrap">
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
            <button type="button" class="password-toggle" data-target="password" aria-label="Tampilkan password"><i class="bi bi-eye"></i></button>
        </div>
        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn btn-primary btn-login">Login</button>
</form>
@endsection

@section('switch')
    Punya akun SIASN? <a href="/login/sso">Login dengan SSO SIASN <i class="bi bi-arrow-right"></i></a>
@endsection
