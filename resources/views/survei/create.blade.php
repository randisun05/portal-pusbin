@extends('layout.main-main')
@section('container')
@include('layout.partial.header-componen')

<!-- Form Usulan Konsultasi -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            @if (session()->has('success'))
                            <div class="alert alert-success col-lg-8" role="alert">
                            {{session('success')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                      
                          @if( $surveis === null || count($surveis) === 0 )

                           <div style="text-align: center; font-weight: bold;" class ="mt-4" >
                              Survei Belum Tersedia
                          </div>

                           <div style="text-align: center;">
                              <a href="/survei" class="btn btn-primary mt-4">Kembali</a>
                          </div>

                          @else

                          <form class="" action="/survei/{{ $surveis }}/create" method="POST">
                                @csrf
                             {{-- Lembar Survei --}}
                             <table class="table mt-4">
                               @if( $type === 1 )
                                <thead>
                                  <tr>
                                    <th scope="col">Lembar Survei</th>
                                    <th scope="col" class="text-center"></th>
                                  </tr>
                                </thead>
                                    <tr>
                                    <th scope="row">NIP</th>
                                    <td class="text-center"><input type="text" class="form-control" value="" name="1" id="1"></td>
                                    </tr>
                                     @foreach ($surveis as $survei )
                                    <tr>
                                      <th scope="row">{{ $survei->indikator->title }}</th>
                                      <td class="text-center"><input type="text" class="form-control" value="" name="1" id="1"></td>
                                    </tr>
                                  @endforeach

                                  @elseif ($type === 2)
                                  <thead>
                                  <tr>
                                    <th scope="col"></th>
                                    <th scope="col" class="text-center"></th>
                                    <th scope="col" class="text-center"></th>
                                  </tr>
                                </thead>
                                 <tr>
                                    <th scope="row">NIP</th>
                                    <td class="text-center" colspan="2"><input type="text" class="form-control" value="" name="1" id="1"></td>
                                  </tr>
                                  @foreach ($surveis as $survei )
                                    <tr>
                                    <th scope="row">{{ $survei->indikator->title }}</th>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="1" name="1" id="1">Ya</td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="2" name="1" id="1">Tidak</td>
                                  </tr>
                                  @endforeach

                             @elseif ($type === 3)
                                <thead>
                                  <tr>
                                    <th scope="col">Indikator</th>
                                    <th scope="col" class="text-center"></th>
                                    <th scope="col" class="text-center"></th>
                                    <th scope="col" class="text-center"></th>
                                    <th scope="col" class="text-center"></th>
                                    <th scope="col" class="text-center"></th>
                                  </tr>
                                </thead>
                                 <tr>
                                    <th scope="row">NIP</th>
                                    <td class="text-center" colspan="5"><input type="text" class="form-control" value="" name="1" id="1"></td>
                                    </tr>
                                  @foreach ($surveis as $survei )
                                    <tr>
                                    <th scope="row">{{ $survei->indikator->title }}</th>
                                    <td class="text-center">Tidak Memuaskan</td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="1" name="1" id="1"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="2" name="1" id="1"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="3" name="1" id="1"></td>
                                    <td class="text-center">Sangat Memuaskan</td>
                                  </tr>
                                  @endforeach
                               @elseif ($type === 4)
                                <thead>
                                  <tr>
                                    <th scope="col">Indikator</th>
                                    <th scope="col" class="text-center"></th>
                                    <th scope="col" class="text-center"></th>
                                    <th scope="col" class="text-center"></th>
                                    <th scope="col" class="text-center"></th>
                                    <th scope="col" class="text-center"></th>
                                    <th scope="col" class="text-center"></th>
                                  </tr>
                                </thead>
                                 <tr>
                                    <th scope="row">NIP</th>
                                    <td class="text-center" colspan="7"><input type="text" class="form-control" value="" name="1" id="1"></td>
                                    </tr>
                                  @foreach ($surveis as $survei )
                                    <tr>
                                    <th scope="row">{{ $survei->indikator->title }}</th>
                                    <td class="text-center">Tidak Memuaskan</td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="1" name="1" id="1"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="2" name="1" id="1"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="3" name="1" id="1"></td>
                                    <td class="text-center"><input class="form-check-input" type="radio" value="4" name="1" id="1"></td>
                                    <td class="text-center">Sangat Memuaskan</td>
                                  </tr>
                                  @endforeach
                              @endif
                              </table>

                            {{-- Button --}}
                            <div class="col text-center m-3">
                             <button type="submit" class="btn btn-primary mb-3" class="" id="kirim">Kirim Survei</button>
                              <a href="/survei" class="btn bbtn btn-primary mb-3">Batal</a>
                            </div>
                        </form>
                            
                          @endif
                          
                        </div>
                    </div>
                </div>

@include('layout.partial.footer')
@endsection
