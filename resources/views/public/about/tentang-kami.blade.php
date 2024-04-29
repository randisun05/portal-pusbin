@extends('layout.main-main')

@section('container')

@include('layout.web.nav')

<main>
@include('layout.web.header-detail')
   <!-- tp-postbox-area-start -->
   <div class="tp-postbox-area pt-120 mb-70">
       <div class="container">
           <div class="row">
               <div class="col-xl-12 col-lg-12 mb-50">
                   <div class="tp-postbox-wrapper">
                      <article class="tp-postbox-item mb-80">
                         <div class="tp-postbox-thumb">
                            <img class="w-100" src="{{asset ('assets/img/blog/blog-thumb-4.jpg') }}" alt="thumb">
                         </div>

                         <div class="tp-postbox-content-2 mb-50 mt-20">
                            <h2 class="tp-postbox-title mb-20">Be in Complete Control Over Your Money</h2>
                            <p class="mb-30">Curabitur luctus euismod metus, eu pellentesque mauris tempus sit amet. Proin ante odio, posuere id lacus auctor, elementum tempor tellus. Integer mattis justo eu enim tempus lacinia. Fusce vitae enim diam. Ut commodo viverra magna non egestas. Integer sodales massa at odio tristique volutpat. Proin posuere odio maximus, eleifend felis sed, ultrices turpis. Proin ultricies sodales nisl vel euismod. Praesent vestibulum sem lorem, eget fermentum justo iaculis et</p>
                            <p>vitae lobortis eros purus non augue. Nullam molestie augue diam, scelerisque porta dolor mollis a. Cras condimentum elementum eros at finibus. pharetra condimentum sagittis. Donec consequat velit et nisi scelerisque, quis iaculis felis tincidunt. In faucibus sapien ut elit hendrerit, et tristique mauris lacinia. Phasellus tincidunt scelerisque lectus sed scelerisque. Donec at enim facilisis, tempus nisi quis, pharetra enim</p>
                         </div>
                      </article>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- tp-postbox-area-end -->
 </main>

@include('layout.web.footer')




@endsection
