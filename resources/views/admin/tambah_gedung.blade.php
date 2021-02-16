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
                            <h3 class="mb-0">{{ __('Tambah Gedung') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="/admin/gedung" class="btn btn-sm btn-primary">{{ __('Gedung') }}</a>
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
                <div class="table-responsive col-md-12">
                    <form method="post" action="/admin/gedung/store" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="pl-lg-1">
                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Nama Gedung') }}</label>
                                <input type="text" name="name" id="input-name" class="form-control form-control-alternative" placeholder="{{ __('Nama Gedung') }}" value="" required>
                                <input type="hidden" name="kode_alamat" value="{{ $kode }}">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Alamat') }}</label>
                                <textarea name="alamat" id="input-name" class="form-control form-control-alternative" placeholder="{{ __('Alamat Gedung') }}" value=""></textarea>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control" name="provinsi" id="provinces" required="">
                                            <option value="" disable="true" selected="true">Pilih Provinsi</option>
                                            @foreach ($provincies as $key => $value)
                                            <option value="{{$value->id}}">{{ $value->name_prov }}</option>
                                            @endforeach
                                        </select></br>
                                        <input type="hidden" name="" id="prov" value="" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="kota" id="regencies" required="">
                                            <option value="" disable="true" selected="true">Pilih Kabupaten/Kota</option>
                                        </select></br>
                                        <input type="hidden" name="" id="city" value="" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="kecamatan" id="districts" required="">
                                            <option value="" disable="true" selected="true">Pilih Kecamatan</option>
                                        </select></br>
                                        <input type="hidden" name="" id="kec" value="" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="kelurahan" id="villages" required="">
                                            <option value="" disable="true" selected="true">Pilih Kelurahan</option>
                                        </select></br>
                                        <input type="hidden" name="" id="kel" value="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="koordinat" id="input-name" class="form-control form-control-alternative" placeholder="{{ __('Koordinat') }}" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="kode_pos" id="input-name" class="form-control form-control-alternative" placeholder="{{ __('Kode Pos') }}" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Kontak') }}</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="nama_kontak" id="input-name" class="form-control form-control-alternative" placeholder="{{ __('Nama Kontak') }}" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="telepon" id="input-name" class="form-control form-control-alternative" placeholder="{{ __('Telepon Kontak') }}" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Jam Operasional Gedung') }}</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="time" name="jam_buka" id="input-name" class="form-control form-control-alternative" placeholder="{{ __('Jam Buka') }}" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="time" name="jam_tutup" id="input-name" class="form-control form-control-alternative" placeholder="{{ __('Jam Tutup') }}" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-control-label" for="input-name">{{ __('Kunci') }}</label>
                                        <select class="form-control" name="kunci" id="kunci">
                                            <option value="0" disable="true" selected="true">Pilih Kunci</option>
                                            <option value="Manual">MANUAL</option>
                                            <option value="Cyber">CYBER</option>
                                            <option value="Manual & Cyber">BOTH</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- <label class="form-control-label" for="input-name">{{ __('Gambar Gedung') }}</label>
                                        <input type="file" name="gambar" id="input-name" class="form-control gambar form-control-alternative" placeholder="{{ __('Gambar') }}" value="" required=""> -->
                                    </div>
                                </div>
                            </div>
                            <div class="text-center modal-footer">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
$('#provinces').on('change', function(e) {
    console.log(e);
    var province_id = e.target.value;
    $.get('/json-regencies?province_id=' + province_id, function(data) {
        console.log(data);
        $('#regencies').empty();
        $('#regencies').append('<option value="" disable="true" selected="true">Pilih Kabupaten/Kota</option>');

        $('#districts').empty();
        $('#districts').append('<option value="" disable="true" selected="true">Pilih Kecamatan</option>');

        $('#villages').empty();
        $('#villages').append('<option value="" disable="true" selected="true">Pilih Kelurahan</option>');

        $.each(data, function(index, regenciesObj) {
            $('#regencies').append('<option value="' + regenciesObj.id + '">' + regenciesObj.name_kab + '</option>');
        })
    });

    $.get('/prov-name?province_id=' + province_id, function(data) {
        console.log(data);

        $.each(data, function(index, provName) {
            $('#prov').val(provName.name_prov);
        })
    });
});

$('#regencies').on('change', function(e) {
    console.log(e);
    var regencies_id = e.target.value;
    $.get('/json-districts?regencies_id=' + regencies_id, function(data) {
        console.log(data);
        $('#districts').empty();
        $('#districts').append('<option value="" disable="true" selected="true">Pilih Kecamatan</option>');

        $('#villages').empty();
        $('#villages').append('<option value="" disable="true" selected="true">Pilih Kelurahan</option>');

        $.each(data, function(index, districtsObj) {
            $('#districts').append('<option value="' + districtsObj.id + '">' + districtsObj.name_kec + '</option>');
        })
    });

    $.get('/city-name?regencies_id=' + regencies_id, function(data) {
        console.log(data);

        $.each(data, function(index, cityName) {
            $('#city').val(cityName.name_kab);
        })
    });
});

$('#districts').on('change', function(e) {
    console.log(e);
    var districts_id = e.target.value;
    $.get('/json-village?districts_id=' + districts_id, function(data) {
        console.log(data);
        $('#villages').empty();
        $('#villages').append('<option value="" disable="true" selected="true">Pilih Kelurahan</option>');

        $.each(data, function(index, villagesObj) {
            $('#villages').append('<option value="' + villagesObj.id + '">' + villagesObj.name_kel + '</option>');
        })
    });

    $.get('/kec-name?districts_id=' + districts_id, function(data) {
        console.log(data);

        $.each(data, function(index, kecName) {
            $('#kec').val(kecName.name_kec);
        })
    });
});

$('#villages').on('change', function(e) {
    console.log(e);
    var villages_id = e.target.value;

    $.get('/kel-name?villages_id=' + villages_id, function(data) {
        console.log(data);

        $.each(data, function(index, kelName) {
            $('#kel').val(kelName.name_kel);
        })
    });
});

</script>
<script type="text/javascript">
$(".gambar").change(function() {
    if (this.files && this.files[0] && this.files[0].name.match(/\.(jpg|png)$/)) {
        if (this.files[0].size > 8048576) {
            $('.logo').val('');
            alert('Batas Maximal Ukuran File 8MB !');
        } else {
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
        }
    } else {
        $('.gambar').val('');
        alert('Hanya File jpg/png Yang Diizinkan !');
    };
});

</script>
@endsection
