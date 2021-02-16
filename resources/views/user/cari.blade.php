@extends('layouts.user')
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">{{ __('Data Gedung') }}</h3>
                        </div>
                    </div>
                </div>
                @foreach ($gedung as $gdg)
                <div class="col-md-12" id="detail_gedung">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <input type="hidden" name="id_gedung" id="id_gedung" value="{{ $gdg->id_gedung }}">
                                <div class="col-md-12 text-center">
                                    <img src="{{ url('/data_file/'.$gdg->gambar) }}" width="50%" height="50%" class="img">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <table class="table table-borderless" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Nama Gedung</th>
                                            <th>{{$gdg->nama_gedung}}</th>
                                        </tr>
                                        <tr>
                                            <th>Alamat<br><br><br></th>
                                            <th>{{$gdg->alamat}}, <br> {{$gdg->name_kel}}, <br> {{$gdg->name_kec}}, <br> {{$gdg->name_kab}}, <br> {{$gdg->name_prov}} - {{$gdg->kode_pos}}</th>
                                        </tr>
                                        <tr>
                                            <th>Koordinat</th>
                                            <th>{{$gdg->koordinat}}</th>
                                        </tr>
                                        <tr>
                                            <th>Contact</th>
                                            <th>{{$gdg->nama_kontak}} - {{$gdg->kontak}}</th>
                                        </tr>
                                        <tr>
                                            <th>Jam Operasional</th>
                                            <th>{{$gdg->jam_buka}} - {{$gdg->jam_tutup}}</th>
                                        </tr>
                                        <tr>
                                            <th>Kunci</th>
                                            <th>{{$gdg->kunci}}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div></br>
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">{{ __('Lantai') }}</h3>
                        </div>
                    </div>
                </div>
                @foreach ($lantai as $lt)
                <div class="col-md-12" id="detail_lantai">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id_lantai" id="id_lantai" value="{{$lt->id_lantai}}">
                                <div class="col-md-12 text-center" id="nama_lantai">
                                    <h1>Lantai "{{$lt->nama_lantai}}"</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">{{ __('Rak') }}</h3>
                        </div>
                    </div>
                </div>
                @foreach ($rak as $r)
                <div class="col-md-12" id="detail_rak">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id_rak" id="id_rak" value="{{$r->id_rak}}">
                                <div class="col-md-12 text-center" id="nama_rak">
                                    <h1>Rak "{{$r->nama_rak}}"</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div></br>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">{{ __('Data Perangkat') }}</h3>
                        </div>
                    </div>
                </div>
                @foreach ($perangkat as $pr)
                <div class="col-md-12" id="detail_perangkat">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id_perangkat" id="id_perangkat" value="{{$pr->id_perangkat}}">
                                <div class="col-md-12 text-center" id="nama_rak">
                                    <h1>Perangkat "{{$pr->nama}} - {{$pr->nama_perangkat}}"</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" width="30%">{{ __('Nama Port') }}</th>
                                <th scope="col" width="70%">{{ __('Keterangan') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($port as $p)
                            <tr>
                                <td>{{$p->nama_port}}</td>
                                <td>{{$p->keterangan}}</td>
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
                <div class="modal-footer">
                    @foreach ($gedung as $gdg)
                        @foreach ($lantai as $lt)
                            @foreach ($rak as $r)
                                @foreach ($perangkat as $pr)
                                <a href="/user/print/{{ $gdg->id_gedung }}/{{ $lt->id_lantai }}/{{ $r->id_rak }}/{{ $pr->id_perangkat }}" target="_blank">
                                    <btn class="btn btn-primary">Print</btn>
                                </a>
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection
