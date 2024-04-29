@extends('layout.main-main')
@section('container')

<main>
    <!-- login-area-srart -->
    <div class="login-area mt-25 pb-30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-7">
                    <div class="tp-login-wrapper">
                        <h3 class="tp-login-title">Login to Admin</h3>
                        {{-- Alert Login Error --}}
                        @if (session('loginerror'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fa fa-exclamation-circle me-2"></i>{{ session('loginerror') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="tp-login-form">
                            <form action="/login" method="post">
                                @csrf
                                <div class="tp-login-input">
                                    <div class="tp-login-input-item mb-25">
                                        <label for="email">Your Email*</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="youremail@gmail.com">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="tp-login-input-item mb-15">
                                        <label for="myInput">Password*</label>
                                        <div class="tp-login-input-eye p-relative">
                                           <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
                                           <span id="click" class="tp-login-eye-btn">
                                              <span class="eye-on">
                                                 <svg width="20" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                 <path opacity="0.5" d="M2.1474 11.1661C1.38247 10.1723 1 9.67544 1 8.2C1 6.72456 1.38247 6.22767 2.1474 5.2339C3.67477 3.2496 6.2363 1 10 1C13.7637 1 16.3252 3.2496 17.8526 5.2339C18.6175 6.22767 19 6.72456 19 8.2C19 9.67544 18.6175 10.1723 17.8526 11.1661C16.3252 13.1504 13.7637 15.4 10 15.4C6.2363 15.4 3.67477 13.1504 2.1474 11.1661Z" stroke="#1C274C" stroke-width="1.5"/>
                                                 <path d="M12.6969 8.2C12.6969 9.69117 11.488 10.9 9.99687 10.9C8.50571 10.9 7.29688 9.69117 7.29688 8.2C7.29688 6.70883 8.50571 5.5 9.99687 5.5C11.488 5.5 12.6969 6.70883 12.6969 8.2Z" stroke="#1C274C" stroke-width="1.5"/>
                                                 </svg>
                                              </span>
                                              <span class="eye-off">
                                                 <svg width="18" height="18" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_2547_24206)">
                                                    <path d="M18.813 18.9113C17.1036 20.2143 15.0222 20.9362 12.873 20.9713C5.87305 20.9713 1.87305 12.9713 1.87305 12.9713C3.11694 10.6532 4.84218 8.62795 6.93305 7.03134M10.773 5.21134C11.4614 5.05022 12.1661 4.96968 12.873 4.97134C19.873 4.97134 23.873 12.9713 23.873 12.9713C23.266 14.1069 22.5421 15.1761 21.713 16.1613M14.993 15.0913C14.7184 15.3861 14.3872 15.6225 14.0192 15.7865C13.6512 15.9504 13.2539 16.0386 12.8511 16.0457C12.4483 16.0528 12.0482 15.9787 11.6747 15.8278C11.3011 15.6769 10.9618 15.4524 10.6769 15.1675C10.392 14.8826 10.1674 14.5433 10.0166 14.1697C9.86567 13.7962 9.79157 13.3961 9.79868 12.9932C9.80579 12.5904 9.89396 12.1932 10.0579 11.8252C10.2219 11.4572 10.4583 11.126 10.753 10.8513" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M1.87305 1.97131L23.873 23.9713" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </g>
                                                    <defs>
                                                    <clipPath id="clip0_2547_24206">
                                                    <rect width="24" height="24" fill="white" transform="translate(0.873047 0.971313)"/>
                                                    </clipPath>
                                                    </defs>
                                                 </svg>
                                              </span>
                                           </span>
                                        </div>
                                     </div>
                                    <div class="tp-login-btn mb-20">
                                        <button type="submit" class="btn btn-primary">LOGIN</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- login-area-end -->
 </main>


    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Sign In Start -->
        <div class="container-fluid">
          <div style="background-image: ;">
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
