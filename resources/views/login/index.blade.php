@extends('layout.main-main')
@section('container')

<main>
    <!-- login-area-srart -->
    <div class="login-area mt-25 pb-30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-7">
                    <div class="tp-login-wrapper">
                        <h3 class="tp-login-title">Login to Alizo</h3>
                        <div class="tp-login-social-wrapper mb-35">
                            <div class="tp-login-social-item mr-10">
                                <a href="#">
                                    <span><svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.9978 9.69089C17.9978 9.04696 17.9472 8.39954 17.8393 7.76605H9.17969V11.4138H14.1386C13.9328 12.5903 13.2717 13.6311 12.3035 14.2924V16.6593H15.262C16.9993 15.0094 17.9978 12.5729 17.9978 9.69089Z" fill="#4285F4"/>
                                        <path d="M9.18072 18.9462C11.6568 18.9462 13.745 18.1074 15.2664 16.6594L12.3079 14.2925C11.4848 14.8703 10.4221 15.1975 9.1841 15.1975C6.78897 15.1975 4.75817 13.5302 4.02951 11.2886H0.976562V13.7286C2.53508 16.9274 5.70947 18.9462 9.18072 18.9462Z" fill="#34A853"/>
                                        <path d="M4.02618 11.2886C3.64161 10.1122 3.64161 8.83821 4.02618 7.66173V5.22174H0.976605C-0.325535 7.89841 -0.325535 11.0519 0.976605 13.7286L4.02618 11.2886Z" fill="#FBBC04"/>
                                        <path d="M9.18072 3.74937C10.4896 3.72849 11.7546 4.23668 12.7026 5.16951L15.3237 2.46499C13.664 0.856896 11.4612 -0.0272074 9.18072 0.00063836C5.70947 0.00063836 2.53508 2.01946 0.976562 5.22172L4.02613 7.6617C4.75142 5.41664 6.78559 3.74937 9.18072 3.74937Z" fill="#EA4335"/>
                                        </svg></span>
                                    <span>Continue With Google</span>
                                </a>
                            </div>
                            <div class="tp-login-social-item">
                                <a href="#"><i class="fa-brands fa-apple"></i></a>
                            </div>
                        </div>
                        <div class="tp-login-form">
                            <form action="#">
                                <div class="tp-login-input">
                                    <div class="tp-login-input-item mb-25">
                                        <label for="email">Your Email*</label>
                                        <input type="text" id="email" placeholder="youremail@gmail.com">
                                    </div>
                                    <div class="tp-login-input-item mb-15">
                                        <label for="myInput">Password*</label>
                                        <div class="tp-login-input-eye p-relative">
                                           <input type="password" id="myInput" placeholder="Enter Password">
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
                                    <div class="tp-login-option mb-20">
                                        <div class="tp-login-remember">
                                            <input id="remember" type="checkbox">
                                            <label for="remember">Keep Me Logged In</label>
                                        </div>
                                        <div class="tp-login-formet">
                                            <a href="#">Forget Password</a>
                                        </div>
                                    </div>
                                    <div class="tp-login-btn mb-20">
                                        <a href="#">LOGIN <i class="fa-solid fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </form>
                            <div class="tp-login-register text-center">
                                <p>Don't have an account? <a href="signup.html">Sign Up</a></p>
                            </div>
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
