@extends('layouts.admin')
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Data Rak') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-primary">{{ __('Add rak') }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('Nama Gedung') }}</th>
                                <th scope="col">{{ __('Nama Lantai') }}</th>
                                <th scope="col">{{ __('Nama Rak') }}</th>
                                <th scope="col">{{ __('Updated At') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rak as $r)
                            <tr>
                                <td>{{ $r->nama_gedung }}</td>
                                <td>{{ $r->nama_lantai }}</td>
                                <td>{{ $r->nama_rak }}</td>
                                <td>{{ $r->updated_at }}</td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" data-toggle="modal" data-target="#modalEdit{{ $r->id_rak }}" href="#">{{ __('Edit') }}</a>
                                            <a class="dropdown-item" data-toggle="modal" data-target="#modalDelete{{ $r->id_rak }}" href="/admin/gedung/delete/{{ $r->id_rak }}">{{ __('Delete') }}</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $rak->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
<!-- Modal Add -->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel-title">
                    <h4>Tambah Rak</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/rak/store" autocomplete="off">
                    @csrf
                    <div class="pl-lg-1">
                        <div class="form-group">
                            <label class="form-control-label" for="input-name">{{ __('Nama Gedung') }}</label>
                            <select class="form-control" name="nama_gedung" id="gedung" required="">
                                <option value="" disable="true" selected="true">Pilih Gedung</option>
                                @foreach ($gedung as $key => $value)
                                <option value="{{$value->id_gedung}}">{{ $value->nama_gedung }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-lantai">{{ __('Nama Lantai') }}</label>
                            <select class="form-control" name="nama_lantai" id="lantai" required="">
                                <option value="" disable="true" selected="true">Pilih Lantai</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-lantai">{{ __('Nama Rak') }}</label>
                            <input type="text" name="nama_rak" id="input-lantai" class="form-control form-control-alternative" placeholder="{{ __('Nama Rak') }}" value="" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@foreach ($rak as $r)
<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $r->id_rak }}" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel-title">
                    <h4>Edit Rak</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/rak/update/{{ $r->id_rak }}" autocomplete="off">
                    @csrf
                    <div class="pl-lg-1">
                        <div class="form-group">
                            <label class="form-control-label" for="input-name">{{ __('Nama Gedung') }}</label>
                            <select class="form-control" name="nama_gedung" id="gedung1{{ $r->id_rak }}" required="">
                                <option value="" disable="true" selected="true">Pilih Gedung</option>
                                @foreach ($gedung as $key => $value)
                                    @if ($value->id_gedung == $r->id_gedung)
                                        <option value="{{$value->id_gedung}}" selected="">{{ $value->nama_gedung }}</option>
                                    @else
                                        <option value="{{$value->id_gedung}}">{{ $value->nama_gedung }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-lantai">{{ __('Nama Lantai') }}</label>
                            <select class="form-control" name="nama_lantai" id="lantai1{{ $r->id_rak }}" required="">
                                <option value="" disable="true" selected="true">Pilih Lantai</option>
                                @foreach ($lantai as $key => $value)
                                    @if ($value->id_lantai == $r->id_lantai)
                                        <option value="{{$value->id_lantai}}" selected="">{{ $value->nama_lantai }}</option>
                                    @elseif ($value->id_lantai != $r->id_lantai && $value->id_gedung == $r->id_gedung)
                                        <option value="{{$value->id_lantai}}">{{ $value->nama_lantai }}</option>
                                    @else
                                        <option value="{{$value->id_lantai}}" style="display: none;" disabled="">{{ $value->nama_lantai }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-lantai">{{ __('Nama Rak') }}</label>
                            <input type="text" name="nama_rak" id="input-lantai" class="form-control form-control-alternative" placeholder="{{ __('Nama Rak') }}" value="{{ $r->nama_rak }}" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach ($rak as $r)
<!-- Modal Delete -->
<div class="modal fade" id="modalDelete{{ $r->id_rak }}" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel-title">
                    <h4>Hapus Rak</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/rak/delete/{{ $r->id_rak }}">
                    @csrf
                    <div class="form-group text-center">
                        <label>Apakah Anda Yakin Untuk Menghapus Data Ini ?</label>
                    </div>
                    <div class="form-group text-center">
                        <label>Menghapus Data Ini Juga Akan Menghapus Data Perangkat, Dan Port Yang Berkaitan Dengan Data Ini.</label>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-success" value="Ya">
                        <button aria-hidden="true" class="btn btn-primary" data-dismiss="modal" class="close right" type="button">Tidak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
@foreach ($rak as $r)
<script type="text/javascript">
//Tambah
$('#gedung').on('change', function(e) {
    console.log(e);
    var id_gedung = e.target.value;
    $.get('/json-lantai?id_gedung=' + id_gedung, function(data) {
        console.log(data);
        $('#lantai').empty();
        $('#lantai').append('<option value="" disable="true" selected="true">Pilih Lantai</option>');

        $.each(data, function(index, lantaiObj) {
            $('#lantai').append('<option value="' + lantaiObj.id_lantai + '">' + lantaiObj.nama_lantai + '</option>');
        })
    });
});

//Edit
$('#gedung1{{ $r->id_rak }}').on('change', function(e) {
    console.log(e);
    var id_gedung = e.target.value;
    $.get('/json-lantai?id_gedung=' + id_gedung, function(data) {
        console.log(data);
        $('#lantai1{{ $r->id_rak }}').empty();
        $('#lantai1{{ $r->id_rak }}').append('<option value="" disable="true" selected="true">Pilih Lantai</option>');

        $.each(data, function(index, lantai) {
            $('#lantai1{{ $r->id_rak }}').append('<option value="' + lantai.id_lantai + '">' + lantai.nama_lantai + '</option>');
        })
    });
});

</script>
@endforeach
@endsection
