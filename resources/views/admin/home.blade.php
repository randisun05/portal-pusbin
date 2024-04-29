

@extends('layout.main-admin')
@section('container')

<!-- Begin Page Content -->

    <div class="container-wrapper">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Halaman Admin Web</h1>
    <!-- Alert -->
    <div class="container-xxl">
    @if (session()->has('success'))
         <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
        @endif
    </div>

      <!-- Content -->
      <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
          <div class="col-lg-8 mb-4 order-0">
            <div class="card">
              <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                  <div class="card-body">
                    <h5 class="card-title text-primary">Selamat Datang {{auth()->user()->name;}}</h5>
                    <p class="mb-4">
                     Selamat Bekerja !!
                    </p>
                  </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                  <div class="card-body pb-0 px-0 px-md-4">
                    {{-- <img
                      src=" "
                      height="140"
                    /> --}}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
              <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                  <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                      <div class="avatar flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-building-fill-up" viewBox="0 0 16 16">
                      <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.354-5.854 1.5 1.5a.5.5 0 0 1-.708.708L13 11.707V14.5a.5.5 0 0 1-1 0v-2.793l-.646.647a.5.5 0 0 1-.708-.708l1.5-1.5a.5.5 0 0 1 .708 0Z"/>
                      <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v7.256A4.493 4.493 0 0 0 12.5 8a4.493 4.493 0 0 0-3.59 1.787A.498.498 0 0 0 9 9.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .39-.187A4.476 4.476 0 0 0 8.027 12H6.5a.5.5 0 0 0-.5.5V16H3a1 1 0 0 1-1-1V1Zm2 1.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5Zm3 0v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM4 5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5ZM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5ZM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z"/>
                    </svg>
                      </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Layanan</span>
                    <h3 class="card-title mb-2">{{$sumlay}}</h3>
                    <small class="text-success fw-semibold">

                    Layanan</small>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                  <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                      <div class="avatar flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-speedometer2" viewBox="0 0 16 16">
                          <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
                          <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"/>
                        </svg>
                      </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Dashboard</span>
                    <h3 class="card-title  text-nowrap mb-1">{{$sumdash}}</h3>
                    <small class="text-success fw-semibold">Dashboard</small>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
              <div class="row row-bordered g-0">
                <div class="col-md-6 text-center">
                    <div class="mt-4"><h3>Layanan Konsultasi</h3> </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                          <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2">{{$sumkonsul}}</h2>
                            <span>Total Konsultasi</span>
                          </div>
                        </div>
                        <ul class="p-0 m-0">
                          <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                              <span class="avatar-initial rounded bg-label-primary"
                                ><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-envelope-check-fill" viewBox="0 0 16 16">
                                  <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 4.697v4.974A4.491 4.491 0 0 0 12.5 8a4.49 4.49 0 0 0-1.965.45l-.338-.207L16 4.697Z"/>
                                  <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686Z"/>
                                  </svg></box-icon></i
                              ></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                              <div class="me-2">
                                <h6 class="mb-0">Telah Dilayani</h6>
                              </div>
                              <div class="user-progress">
                                <small class="fw-semibold">{{$konsuldilayani}}</small>
                              </div>
                            </div>
                          </li>
                          <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                              <span class="avatar-initial rounded bg-label-success"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-envelope-exclamation-fill" viewBox="0 0 16 16">
                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 4.697v4.974A4.491 4.491 0 0 0 12.5 8a4.49 4.49 0 0 0-1.965.45l-.338-.207L16 4.697Z"/>
                                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1.5a.5.5 0 0 1-1 0V11a.5.5 0 0 1 1 0Zm0 3a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"/>
                              </svg></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                              <div class="me-2">
                                <h6 class="mb-0">Belum Dilayani</h6>

                              </div>
                              <div class="user-progress">
                                <small class="fw-semibold"></small>
                              </div>
                            </div>
                          </li>
                        </ul>
                      </div>
                </div>


                <div class="col-md-6 text-center">
                   <div class="mt-4"><h3>Layanan Publikasi</h3> </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                          <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2">{{$sum}}</h2>
                            <span>Total Publikasi</span>
                          </div>
                        </div>
                        <ul class="p-0 m-0">
                          <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                              <span class="avatar-initial rounded bg-label-primary"
                                ><box-icon name='book-reader'></box-icon></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                              <div class="me-2">
                                <h6 class="mb-0">Umum</h6>

                              </div>
                              <div class="user-progress">
                                <small class="fw-semibold">{{$sumumum}}</small>
                              </div>
                            </div>
                          </li>
                          <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                              <span class="avatar-initial rounded bg-label-success"> <box-icon type='solid' name='megaphone'></box-icon></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                              <div class="me-2">
                                <h6 class="mb-0">Pengumuman</h6>

                              </div>
                              <div class="user-progress">
                                <small class="fw-semibold">{{$sumpeng}}</small>
                              </div>
                            </div>
                          </li>
                          <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                              <span class="avatar-initial rounded bg-label-info"><box-icon name='task' ></box-icon></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                              <div class="me-2">
                                <h6 class="mb-0">Kegiatan</h6>

                              </div>
                              <div class="user-progress">
                                <small class="fw-semibold">{{$sumkegiatan}}</small>
                              </div>
                            </div>
                          </li>
                        </ul>
                      </div>
                </div>
              </div>
            </div>
          </div>
          <!--/ Total Revenue -->


          <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2q">
            <div class="row">
              <div class="col-6 mb-4">
                <div class="card">
                  <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                      <div class="avatar flex-shrink-0">
                        <box-icon type='solid' name='megaphone'></box-icon>
                      </div>
                    </div>
                    <span class="d-block mb-1">Kategori Pengumuman</span>
                    <h3 class="card-title text-nowrap mb-2">{{$sumpeng}}</h3>
                    <small class="text-success fw-semibold">Kategori Pengumuman<i class="bx bx-down-arrow-alt"></i> </small>
                  </div>
                </div>
              </div>
              <div class="col-6 mb-4">
                <div class="card">
                  <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                      <div class="avatar flex-shrink-0">
                        <box-icon name='task' ></box-icon>
                      </div>
                    </div>
                    <span>Kategori Kegiatan</span>
                    <h3 class="card-title mb-2">{{$sumkegiatan}}</h3>
                    <small class="text-success fw-semibold">Kategori Kegiatan<i class="bx bx-up-arrow-alt"></i> </small>
                  </div>
                </div>
              </div>
              <!-- </div>
<div class="row"> -->

            </div>
          </div>
        </div>
        <div class="row">
        </div>
      </div>
      <!-- / Content -->

</div>
@endsection
