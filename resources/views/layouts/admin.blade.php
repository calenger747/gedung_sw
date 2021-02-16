<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Argon Dashboard') }} - Admin</title>
    <!-- Favicon -->
    <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
</head>

<body class="{{ $class ?? '' }}">
    @include('layouts.navbars.sidebar')
    <div class="main-content">
        @include('layouts.navbars.navs.auth')
        @yield('content')
    </div>
    <!-- Modal Cari -->
    <div class="modal fade" id="modalCari" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="panel-title">
                        <h4>Cari Data</h4>
                    </div>
                    <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/admin/search" autocomplete="off">
                        @csrf
                        <div class="pl-lg-1">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-control-label" for="input-name">{{ __('Nama Gedung') }}</label>
                                        <select class="form-control" name="nama_gedung" id="gedung" required="">
                                            <option value="" disable="true" selected="true">Pilih Gedung</option>
                                            @foreach ($g as $key => $value)
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
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Search') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
    //Tambah
    $('#gedung').on('change', function(e) {
        console.log(e);
        var id_gedung = e.target.value;
        $.get('/json-lantai-cari?id_gedung=' + id_gedung, function(data) {
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
        $.get('/json-rak-cari?id_lantai=' + id_lantai, function(data) {
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
        $.get('/json-perangkat-cari?id_rak=' + id_rak, function(data) {
            console.log(data);

            $('#perangkat').empty();
            $('#perangkat').append('<option value="" disable="true" selected="true">Pilih Perangkat</option>');


            $.each(data, function(index, perangkatObj) {
                $('#perangkat').append('<option value="' + perangkatObj.id_perangkat + '">' + perangkatObj.nama_perangkat + '</option>');
            })
        });
    });

    </script>
    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    @stack('js')
    <!-- Argon JS -->
    <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
</body>

</html>
