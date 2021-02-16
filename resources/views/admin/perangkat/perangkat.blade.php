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
                            <h3 class="mb-0">{{ __('Data Perangkat') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-primary">{{ __('Add perangkat') }}</a>
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
                    @elseif (session('status_fail'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('status_fail') }}
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
                                <th scope="col">{{ __('Jenis Perangkat') }}</th>
                                <th scope="col">{{ __('Nama Perangkat') }}</th>
                                <th scope="col">{{ __('Updated At') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($perangkat as $pr)
                            <tr>
                                <td>{{ $pr->nama_gedung }}</td>
                                <td>{{ $pr->nama_lantai }}</td>
                                <td>{{ $pr->nama_rak }}</td>
                                <td>{{ $pr->nama }}</td>
                                <td>{{ $pr->nama_perangkat }}</td>
                                <td>{{ $pr->updated_at }}</td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" data-toggle="modal" data-target="#modalEdit{{ $pr->id_perangkat }}" href="#">{{ __('Edit') }}</a>
                                            <a class="dropdown-item" data-toggle="modal" data-target="#modalDelete{{ $pr->id_perangkat }}" href="#">{{ __('Delete') }}</a>
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
                        {{ $perangkat->links() }}
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
                    <h4>Tambah Perangkat</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/perangkat/store" autocomplete="off">
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
                                    <label class="form-control-label" for="input-name">{{ __('Jenis Perangkat') }}</label>
                                    <select class="form-control" name="nama_jenis" id="jenis" required="">
                                        <option value="" disable="true" selected="true">Pilih Jenis Perangkat</option>
                                        @foreach ($jenis as $key => $value)
                                        <option value="{{$value->id}}">{{ $value->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-lantai">{{ __('Nama Perangkat') }}</label>
                            <input type="text" name="nama_perangkat" id="input-lantai" class="form-control form-control-alternative" placeholder="{{ __('Nama Perangkat') }}" value="" required>
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
@foreach ($perangkat as $pr)
<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $pr->id_perangkat }}" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel-title">
                    <h4>Edit Perangkat</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/perangkat/update/{{ $pr->id_perangkat }}" autocomplete="off">
                    @csrf
                    <div class="pl-lg-1">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Gedung') }}</label>
                                    <select class="form-control" name="nama_gedung" id="gedung1{{ $pr->id_perangkat }}" required="">
                                        <option value="" disable="true" selected="true">Pilih Gedung</option>
                                        @foreach ($gedung as $key => $value)
                                        @if ($value->id_gedung == $pr->id_gedung)
                                        <option value="{{$value->id_gedung}}" selected="">{{ $value->nama_gedung }}</option>
                                        @else
                                        <option value="{{$value->id_gedung}}">{{ $value->nama_gedung }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Lantai') }}</label>
                                    <select class="form-control" name="nama_lantai" id="lantai1{{ $pr->id_perangkat }}" required="">
                                        <option value="" disable="true" selected="true">Pilih Lantai</option>
                                        @foreach ($lantai as $key => $value)
                                        @if ($value->id_lantai == $pr->id_lantai)
                                        <option value="{{$value->id_lantai}}" selected="">{{ $value->nama_lantai }}</option>
                                        @elseif ($value->id_lantai != $pr->id_lantai && $value->id_gedung == $pr->id_gedung)
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
                                    <select class="form-control" name="nama_rak" id="rak1{{ $pr->id_perangkat }}" required="">
                                        <option value="" disable="true" selected="true">Pilih Gedung</option>
                                        @foreach ($rak as $key => $value)
                                        @if ($value->id_rak == $pr->id_rak)
                                        <option value="{{$value->id_rak}}" selected="" readonly>{{ $value->nama_rak }}</option>
                                        @elseif ($value->id_rak != $pr->id_rak && $value->id_gedung == $pr->id_gedung)
                                        <option value="{{$value->id_rak}}">{{ $value->nama_rak }}</option>
                                        @else
                                        <option value="{{$value->id_rak}}" style="display: none;">{{ $value->nama_rak }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-name">{{ __('Jenis Perangkat') }}</label>
                                    <select class="form-control" name="nama_jenis" id="jenis1" required="">
                                        <option value="" disable="true" selected="true">Pilih Jenis Perangkat</option>
                                        @foreach ($jenis as $key => $value)
                                        @if ($value->id == $pr->id_jenis)
                                        <option value="{{$value->id}}" selected="">{{ $value->nama }}</option>
                                        @else
                                        <option value="{{$value->id}}">{{ $value->nama }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-lantai">{{ __('Nama Perangkat') }}</label>
                            <input type="text" name="nama_perangkat" id="input-lantai" class="form-control form-control-alternative" placeholder="{{ __('Nama Perangkat') }}" value="{{ $pr->nama_perangkat }}" required>
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
@foreach ($perangkat as $pr)
<!-- Modal Delete -->
<div class="modal fade" id="modalDelete{{ $pr->id_perangkat }}" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel-title">
                    <h4>Hapus Perangkat</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/perangkat/delete/{{ $pr->id_perangkat }}">
                    @csrf
                    <div class="form-group text-center">
                        <label>Apakah Anda Yakin Untuk Menghapus Data Ini ?</label>
                    </div>
                    <div class="form-group text-center">
                        <label>Menghapus Data Ini Juga Akan Menghapus Data Port Yang Berkaitan Dengan Data Ini.</label>
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
@foreach ($perangkat as $pr)
<script type="text/javascript">
//Tambah
$('#gedung').on('change', function(e) {
    console.log(e);
    var id_gedung = e.target.value;
    $.get('/json-lantai-rak?id_gedung=' + id_gedung, function(data) {
        console.log(data);
        $('#lantai').empty();
        $('#lantai').append('<option value="" disable="true" selected="true">Pilih Lantai</option>');

        $('#rak').empty();
        $('#rak').append('<option value="" disable="true" selected="true">Pilih Rak</option>');

        $.each(data, function(index, lantaiObj) {
            $('#lantai').append('<option value="' + lantaiObj.id_lantai + '">' + lantaiObj.nama_lantai + '</option>');
        })
    });
});
$('#lantai').on('change', function(e) {
    console.log(e);
    var id_lantai = e.target.value;
    $.get('/json-rak-rak?id_lantai=' + id_lantai, function(data) {
        console.log(data);

        $('#rak').empty();
        $('#rak').append('<option value="" disable="true" selected="true">Pilih Rak</option>');

        $.each(data, function(index, rakObj) {
            $('#rak').append('<option value="' + rakObj.id_rak + '">' + rakObj.nama_rak + '</option>');
        })
    });
});

//Edit
$('#gedung1{{ $pr->id_perangkat }}').on('change', function(e) {
    console.log(e);
    var id_gedung = e.target.value;
    $.get('/json-lantai-rak?id_gedung=' + id_gedung, function(data) {
        console.log(data);
        $('#lantai1{{ $pr->id_perangkat }}').empty();
        $('#lantai1{{ $pr->id_perangkat }}').append('<option value="" disable="true" selected="true">Pilih Lantai</option>');

        $('#rak1{{ $pr->id_perangkat }}').empty();
        $('#rak1{{ $pr->id_perangkat }}').append('<option value="" disable="true" selected="true">Pilih Rak</option>');

        $.each(data, function(index, lantai) {
            $('#lantai1{{ $pr->id_perangkat }}').append('<option value="' + lantai.id_lantai + '">' + lantai.nama_lantai + '</option>');
        })
    });
});
$('#lantai1{{ $pr->id_perangkat }}').on('change', function(e) {
    console.log(e);
    var id_lantai = e.target.value;
    $.get('/json-rak-rak?id_lantai=' + id_lantai, function(data) {
        console.log(data);

        $('#rak1{{ $pr->id_perangkat }}').empty();
        $('#rak1{{ $pr->id_perangkat }}').append('<option value="" disable="true" selected="true">Pilih Rak</option>');

        $.each(data, function(index, rak) {
            $('#rak1{{ $pr->id_perangkat }}').append('<option value="' + rak.id_rak + '">' + rak.nama_rak + '</option>');
        })
    });
});

</script>
@endforeach
@endsection
