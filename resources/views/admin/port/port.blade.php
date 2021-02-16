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
                            <h3 class="mb-0">{{ __('Data Port') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-primary">{{ __('Add port') }}</a>
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
                                <th scope="col">{{ __('Nama Perangkat') }}</th>
                                <th scope="col">{{ __('Nama Port') }}</th>
                                <th scope="col">{{ __('Keterangan') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($port as $p)
                            <tr>
                                <td>{{ $p->nama_gedung }}</td>
                                <td>{{ $p->nama_lantai }}</td>
                                <td>{{ $p->nama_rak }}</td>
                                <td>{{ $p->nama_perangkat }}</td>
                                <td>{{ $p->nama_port }}</td>
                                <td>{{ $p->keterangan }}</td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" data-toggle="modal" data-target="#modalEdit{{ $p->id_port }}" href="#">{{ __('Edit') }}</a>
                                            <a class="dropdown-item" data-toggle="modal" data-target="#modalDelete{{ $p->id_port }}" href="#">{{ __('Delete') }}</a>
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
                        {{ $port->links() }}
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
                    <h4>Tambah Port</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/port/store" autocomplete="off">
                    @csrf
                    <div class="pl-lg-1">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Gedung') }}</label>
                                    <select class="form-control" name="nama_gedung" id="gedung" required="">
                                        <option value="" disable="true" selected="true">Pilih Gedung</option>
                                        @foreach ($gedung as $key => $value)
                                        <option value="{{$value->id_gedung}}">{{ $value->nama_gedung }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Lantai') }}</label>
                                    <select class="form-control" name="nama_lantai" id="lantai" required="">
                                        <option value="" disable="true" selected="true">Pilih Lantai</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Rak') }}</label>
                                    <select class="form-control" name="nama_rak" id="rak" required="">
                                        <option value="" disable="true" selected="true">Pilih Rak</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Perangkat') }}</label>
                                    <select class="form-control" name="nama_perangkat" id="perangkat" required="">
                                        <option value="" disable="true" selected="true">Pilih Perangkat</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-lantai">{{ __('Nama Port') }}</label>
                                    <input type="text" name="nama_port" id="input-lantai" class="form-control form-control-alternative" placeholder="{{ __('Nama Port') }}" value="" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-lantai">{{ __('Keterangan') }}</label>
                                    <input type="text" name="keterangan" id="input-lantai" class="form-control form-control-alternative" placeholder="{{ __('Keterangan') }}" value="" required>
                                </div>
                            </div>
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
@foreach ($port as $p)
<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $p->id_port }}" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel-title">
                    <h4>Edit Port</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/port/update/{{ $p->id_port }}" autocomplete="off">
                    @csrf
                    <div class="pl-lg-1">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Gedung') }}</label>
                                    <select class="form-control" name="nama_gedung" id="gedung1{{ $p->id_port }}" required="">
                                        <option value="" disable="true" selected="true">Pilih Gedung</option>
                                        @foreach ($gedung as $key => $value)
                                            @if ($value->id_gedung == $p->id_gedung)
                                                <option value="{{$value->id_gedung}}" selected="">{{ $value->nama_gedung }}</option>
                                            @else
                                                <option value="{{$value->id_gedung}}">{{ $value->nama_gedung }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Lantai') }}</label>
                                    <select class="form-control" name="nama_lantai" id="lantai1{{ $p->id_port }}" required="">
                                        <option value="" disable="true" selected="true" readonly>Pilih Lantai</option>
                                        @foreach ($lantai as $key => $value)
                                            @if ($value->id_lantai == $p->id_lantai)
                                                <option value="{{$value->id_lantai}}" selected="">{{ $value->nama_lantai }}</option>
                                            @elseif ($value->id_lantai != $p->id_lantai && $value->id_gedung == $p->id_gedung)
                                                <option value="{{$value->id_lantai}}">{{ $value->nama_lantai }}</option>
                                            @else
                                                <option value="{{$value->id_lantai}}" style="display: none;" disabled="">{{ $value->nama_lantai }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Rak') }}</label>
                                    <select class="form-control" name="nama_rak" id="rak1{{ $p->id_port }}" required="">
                                        <option value="" disable="true" selected="true">Pilih Rak</option>
                                        @foreach ($rak as $key => $value)
                                            @if ($value->id_rak == $p->id_rak)
                                                <option value="{{$value->id_rak}}" selected="" readonly>{{ $value->nama_rak }}</option>
                                            @elseif ($value->id_rak != $p->id_rak && $value->id_gedung == $p->id_gedung)
                                                <option value="{{$value->id_rak}}">{{ $value->nama_rak }}</option>
                                            @else
                                                <option value="{{$value->id_rak}}" style="display: none;">{{ $value->nama_rak }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Perangkat') }}</label>
                                    <select class="form-control" name="nama_perangkat" id="perangkat1{{ $p->id_port }}" required="">
                                        <option value="" disable="true" selected="true">Pilih Perangkat</option>
                                        @foreach ($perangkat as $key => $value)
                                            @if ($value->id_perangkat == $p->id_perangkat)
                                                <option value="{{$value->id_perangkat}}" selected="" readonly>{{ $value->nama_perangkat }}</option>
                                            @elseif ($value->id_perangkat != $p->id_perangkat && $value->id_gedung == $p->id_gedung)
                                                <option value="{{$value->id_perangkat}}">{{ $value->nama_perangkat }}</option>
                                            @else
                                                <option value="{{$value->id_perangkat}}" style="display: none;">{{ $value->nama_perangkat }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-lantai">{{ __('Nama Port') }}</label>
                                    <input type="text" name="nama_port" id="input-lantai" class="form-control form-control-alternative" placeholder="{{ __('Nama Port') }}" value="{{ $p->nama_port }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-lantai">{{ __('Keterangan') }}</label>
                                    <input type="text" name="keterangan" id="input-lantai" class="form-control form-control-alternative" placeholder="{{ __('Keterangan') }}" value="{{ $p->keterangan }}" required>
                                </div>
                            </div>
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
@foreach ($port as $r)
<!-- Modal Delete -->
<div class="modal fade" id="modalDelete{{ $r->id_port }}" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel-title">
                    <h4>Hapus Port</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/port/delete/{{ $r->id_port }}">
                    @csrf
                    <div class="form-group text-center">
                        <label>Apakah Anda Yakin Untuk Menghapus Data Ini ?</label>
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
@foreach ($port as $p)
<script type="text/javascript">
//Tambah
$('#gedung').on('change', function(e) {
    console.log(e);
    var id_gedung = e.target.value;
    $.get('/json-lantai-port?id_gedung=' + id_gedung, function(data) {
        console.log(data);
        $('#lantai').empty();
        $('#lantai').append('<option value="" disable="true" selected="true">Pilih Lantai</option>');

        $('#rak').empty();
        $('#rak').append('<option value="" disable="true" selected="true">Pilih Rak</option>');

        $('#perangkat').empty();
        $('#perangkat').append('<option value="" disable="true" selected="true">Pilih Perangkat</option>');

        $.each(data, function(index, lantaiObj) {
            $('#lantai').append('<option value="' + lantaiObj.id_lantai + '">' + lantaiObj.nama_lantai + '</option>');
        })
    });
});
$('#lantai').on('change', function(e) {
    console.log(e);
    var id_lantai = e.target.value;
    $.get('/json-rak-port?id_lantai=' + id_lantai, function(data) {
        console.log(data);

        $('#rak').empty();
        $('#rak').append('<option value="" disable="true" selected="true">Pilih Rak</option>');

        $('#perangkat').empty();
        $('#perangkat').append('<option value="" disable="true" selected="true">Pilih Perangkat</option>');


        $.each(data, function(index, rakObj) {
            $('#rak').append('<option value="' + rakObj.id_rak + '">' + rakObj.nama_rak + '</option>');
        })
    });
});
$('#rak').on('change', function(e) {
    console.log(e);
    var id_rak = e.target.value;
    $.get('/json-perangkat-port?id_rak=' + id_rak, function(data) {
        console.log(data);

        $('#perangkat').empty();
        $('#perangkat').append('<option value="" disable="true" selected="true">Pilih Perangkat</option>');
        

        $.each(data, function(index, perangkatObj) {
            $('#perangkat').append('<option value="' + perangkatObj.id_perangkat + '">' + perangkatObj.nama_perangkat + '</option>');
        })
    });
});

//Edit
$('#gedung1{{ $p->id_port }}').on('change', function(e) {
    console.log(e);
    var id_gedung = e.target.value;
    $.get('/json-lantai-port?id_gedung=' + id_gedung, function(data) {
        console.log(data);
        $('#lantai1{{ $p->id_port }}').empty();
        $('#lantai1{{ $p->id_port }}').append('<option value="" disable="true" selected="true">Pilih Lantai</option>');

        $('#rak1{{ $p->id_port }}').empty();
        $('#rak1{{ $p->id_port }}').append('<option value="" disable="true" selected="true">Pilih Rak</option>');

        $('#perangkat1{{ $p->id_port }}').empty();
        $('#perangkat1{{ $p->id_port }}').append('<option value="" disable="true" selected="true">Pilih Perangkat</option>');

        $.each(data, function(index, lantai) {
            $('#lantai1{{ $p->id_port }}').append('<option value="' + lantai.id_lantai + '">' + lantai.nama_lantai + '</option>');
        })
    });
});
$('#lantai1{{ $p->id_port }}').on('change', function(e) {
    console.log(e);
    var id_lantai = e.target.value;
    $.get('/json-rak-port?id_lantai=' + id_lantai, function(data) {
        console.log(data);

        $('#rak1{{ $p->id_port }}').empty();
        $('#rak1{{ $p->id_port }}').append('<option value="" disable="true" selected="true">Pilih Rak</option>');

        $('#perangkat1{{ $p->id_port }}').empty();
        $('#perangkat1{{ $p->id_port }}').append('<option value="" disable="true" selected="true">Pilih Perangkat</option>');

        $.each(data, function(index, rak) {
            $('#rak1{{ $p->id_port }}').append('<option value="' + rak.id_rak + '">' + rak.nama_rak + '</option>');
        })
    });
});
$('#rak1{{ $p->id_port }}').on('change', function(e) {
    console.log(e);
    var id_rak = e.target.value;
    $.get('/json-perangkat-port?id_rak=' + id_rak, function(data) {
        console.log(data);

        $('#perangkat1{{ $p->id_port }}').empty();
        $('#perangkat1{{ $p->id_port }}').append('<option value="" disable="true" selected="true">Pilih Perangkat</option>');
        

        $.each(data, function(index, perangkat) {
            $('#perangkat1{{ $p->id_port }}').append('<option value="' + perangkat.id_perangkat + '">' + perangkat.nama_perangkat + '</option>');
        })
    });
});

</script>
@endforeach
@endsection
