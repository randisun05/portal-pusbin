@extends('layout.main-main')
@section('container')
@include('layout.web.nav')
@include('layout.web.header-detail')
<!-- Form Usulan Konsultasi -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 offset-md-4">

                             {{-- Deskripsi Perihal --}}

                             <table class="table mt-4">
                                <thead>
                                  <tr>
                                    <th scope="col" class="text-center" width="10%">No</th>
                                    <th scope="col" class="text-center">Nama Survei</th>
                                    <th scope="col" class="text-center"></th>
                                  </tr>
                                </thead>
                                @foreach ($surveis as $survei )
                                        <tr>
                                            <td class="text-center">{{$loop->iteration}}.</td>
                                            <td>{{$survei->title  }}</td>
                                            <td class="text-center"><a href="/survei/{{$survei->id}}/create" class="badge bg-warning">Isi Survei </a></td>
                                        </tr>
                                @endforeach
                              </table>
                        </div>
                    </div>
                </div>

<div class="padingfooter">
@include('layout.partial.footer')
</div>
@endsection
