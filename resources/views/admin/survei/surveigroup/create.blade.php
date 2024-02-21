@extends('layout.main-admin')
@section('container')

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 mt-5 text-center">Daftar Indikator</h1>
    @if (session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
        {{session('success')}}
        </div>
    @endif

    <!-- Main Content -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="survei" action="/admin/survei/{{ $survei->id }}/store" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="survei_id" value="{{ $survei->id }}">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="border-0 rounded-start" style="width:5%">
                                    <input type="checkbox" onchange="toggleCheckboxes(this)" />
                                </th>
                                <th class="text-center">Indikator</th>
                            </tr>
                        </thead>
                        @foreach ($indikators as $indikator )
                        <tr>
                            <td>
                                <input type="checkbox" name="indikator_id[]" value="{{ $indikator->id }}" />
                            </td>
                            <td>{{$indikator->title}}</td>
                        </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                               <th class="text-center"></th>
                                <th class="text-center">Indikator</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                        <div class="col text-center m-3">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                            <a href="/admin/survei/{{ $survei->id }}" class="btn btn-primary ms-2">Batal</a>
                        </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Main Content -->
<script>
    function toggleCheckboxes(masterCheckbox) {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach((checkbox) => {
            if (checkbox !== masterCheckbox) {
                checkbox.checked = masterCheckbox.checked;
            }
        });
    }
</script>

@endsection
