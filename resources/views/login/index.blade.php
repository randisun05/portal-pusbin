@extends('layout.main-main')
@section('container')


    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Sign In Start -->
        <div class="container-fluid">
          <div style="background-image: url('/img/bg.webp');">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-3">
                    <div class="shadow bg-light rounded p-4 p-sm-5 my-4 mx-3">

                        {{-- Alert Login Error --}}
                        @if (session('loginerror'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fa fa-exclamation-circle me-2"></i>{{ session('loginerror') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- FORM LOGIN --}}
                        <form action="/login" method="post">
                            @csrf
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <h3 class="txt-clr">Login Admin</h3>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email or Ussername" value="{{ old('email') }}" required autofocus>
                                <label for="nip">Email</label>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                                <label for="floatingPassword">Password</label>
                                @error('password')
                                <div class="invalid-feedback">
                                     {{$message}}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Login</button>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <!-- Sign In End -->
    </div>

@endsection
