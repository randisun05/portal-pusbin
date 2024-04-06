 <div class="testimonial-area p-relative pb-35">
    <img class="tp-testimonial-shape tree-move d-none d-lg-block p-absolute" src="assets/img/testimonial/07.png" alt="07">
    <div class="container">
       <div class="row">
          <div class="col-12">
             <div class="tp-section-title-wrapper text-center p-relative mb-60 wow fadeInUp" data-wow-delay=".3s" data-wow-duration="1s" >
                <span class="tp-section-title-pre tp-section-title-pre4">Pendukung</span>
                <h2 class="tp-section-title">Layanan Kami</h2>
             </div>
          </div>
          <div class="service-area pb-90">
            <div class="container">
               <div class="row">
                @foreach ($layanans as $layanan )
                  <div class="col-lg-3 col-md-6 mb-25">
                    <a href={{$layanan->link}}>
                     <div class="tp-service-bus-wrap text-center wow fadeInUp" data-wow-delay=".3s" data-wow-duration="1s">
                        <div class="tp-service-bus">
                           <i><img src="{{asset('storage/' . $layanan->image)}}" width="100 px"></i>
                        </div>
                        <div class="tp-service-bus-con">
                           <h3 class="tp-service-bus-tit"><a href="service-details.html">{{$layanan->nama}}</a></h3>
                        </div>
                     </div>
                    </a>
                  </div>
                @endforeach

               </div>
            </div>
         </div>
       </div>
    </div>
 </div>
