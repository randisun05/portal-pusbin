<div class="testimonial-counter pt-160">
    <div class="container">
       <div class="row">
          <div class="col-xl-3 col-lg-6 col-md-6">
             <div class="tp-testimonial-counter p-relative mb-70 wow fadeInUp" data-wow-delay=".3s" data-wow-duration="1s">
                <h3 class="tp-testimonial-counter-title"><span class="counter2 home-counter" data-count="{{ $jumlahOrganisasi }}">0</span></h3>
                <h5 class="tp-testimonial-counter-title-pre">Pejabat &amp; Tim</h5>
                <div class="tp-testimonial-counter-icon p-absolute">
                   <i class="flaticon-risk-management"></i>
                </div>
             </div>
          </div>
          <div class="col-xl-3 col-lg-6 col-md-6">
             <div class="tp-testimonial-counter p-relative mb-70 wow fadeInUp" data-wow-delay=".5s" data-wow-duration="1s">
                <h3 class="tp-testimonial-counter-title"><span class="counter2 home-counter" data-count="{{ $jumlahLayanan }}">0</span></h3>
                <h5 class="tp-testimonial-counter-title-pre">Layanan Aktif</h5>
                <div class="tp-testimonial-counter-icon p-absolute">
                   <i class="flaticon-rating-1"></i>
                </div>
             </div>
          </div>
          <div class="col-xl-3 col-lg-6 col-md-6">
             <div class="tp-testimonial-counter p-relative mb-70 wow fadeInUp" data-wow-delay=".7s" data-wow-duration="1s">
                <h3 class="tp-testimonial-counter-title"><span class="counter2 home-counter" data-count="{{ $jumlahKegiatan }}">0</span></h3>
                <h5 class="tp-testimonial-counter-title-pre">Kegiatan Terlaksana</h5>
                <div class="tp-testimonial-counter-icon p-absolute">
                   <i class="flaticon-management"></i>
                </div>
             </div>
          </div>
          <div class="col-xl-3 col-lg-6 col-md-6">
             <div class="tp-testimonial-counter p-relative mb-70 wow fadeInUp" data-wow-delay=".9s" data-wow-duration="1s">
                <h3 class="tp-testimonial-counter-title"><span class="counter2 home-counter" data-count="{{ $jumlahPublikasi }}">0</span></h3>
                <h5 class="tp-testimonial-counter-title-pre">Publikasi</h5>
                <div class="tp-testimonial-counter-icon p-absolute">
                   <i class="flaticon-people"></i>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>

 <script>
 (function () {
     var counters = document.querySelectorAll('.home-counter');
     if (!counters.length) return;
     var animated = false;

     function animate() {
         if (animated) return;
         animated = true;
         counters.forEach(function (el) {
             var target = parseInt(el.dataset.count, 10) || 0;
             var current = 0;
             var step = Math.max(1, Math.ceil(target / 40));
             var timer = setInterval(function () {
                 current += step;
                 if (current >= target) {
                     current = target;
                     clearInterval(timer);
                 }
                 el.textContent = current;
             }, 25);
         });
     }

     if ('IntersectionObserver' in window) {
         var observer = new IntersectionObserver(function (entries) {
             entries.forEach(function (entry) {
                 if (entry.isIntersecting) {
                     animate();
                     observer.disconnect();
                 }
             });
         });
         observer.observe(counters[0]);
     } else {
         animate();
     }
 })();
 </script>
