 <!-- Navbar & Hero Start -->
 <div class="container-fluid position-relative p-0">
    @include('layout.partial.nav')

    <!-- Header Componen -->
    <div class="py-2 bg-primary hero-header">
        <div class="container my-5 py-3 px-lg-5">
            <div class="row g-5 py-5">
                <div class="col-12 text-center">
                    <h1 class="text-white animated slideInDown">{{$title,'Halaman Tidak Tersedia'}}</h1>
                    <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                </div>
                <div class="row justify-content-center mb-3 mt-4">
                    <div class="col-md-6">
                        <form action="" method="GET">
                            @if (request('category'))
                            <input type="hidden" name="category" value="{{request('category')}}">

                            @endif
                            @if (request('author'))
                            <input type="hidden" name="author" value="{{request('author')}}">

                            @endif
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search..." name="search" value="{{request('search')}}">
                                <button class="btn btn-danger" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- Navbar & Hero End -->
