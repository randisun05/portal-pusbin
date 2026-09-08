<footer class="tp-grey-insu">
    <div class="footer-bootom-insu">
       <div class="container">
          <div class="row">
             <div class="col-lg-12">
                <div class="tp-footer-bottom tp-footer-bottom-insu text-center">
                   <p class="m-0">Pusat Pembinaan Jabatan Fungsional Kepegawaian | BKN – {{ date('Y') }}</p>
                   <p>
                        {{ $profil->alamat ?? 'Jl. Mayjen Sutoyo No. 12, Jakarta Timur, 13640 – Indonesia' }}
                        @if($profil->telepon) | Telp. {{ $profil->telepon }} @endif
                        @if($profil->email) | Email {{ $profil->email }} @endif
                   </p>
                   <div class="tp-footer-social tp-footer-social-insu text-center">
                    @if($profil->instagram)<a href="{{ $profil->instagram }}" target="_blank"><i class="fa-brands fa-instagram"></i></a>@endif
                    @if($profil->facebook)<a href="{{ $profil->facebook }}" target="_blank"><i class="fa-brands fa-facebook"></i></a>@endif
                    @if($profil->youtube)<a href="{{ $profil->youtube }}" target="_blank"><i class="fa-brands fa-youtube"></i></a>@endif
                    @if($profil->twitter)<a href="{{ $profil->twitter }}" target="_blank"><i class="fa-brands fa-twitter"></i></a>@endif
                 </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </footer>
