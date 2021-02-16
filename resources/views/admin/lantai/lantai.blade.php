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
                                <h3 class="mb-0">{{ __('Data Lantai') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="#" data-toggle="modal" data-target="#modalAdd" class="btn btn-sm btn-primary">{{ __('Add lantai') }}</a>
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
                                    <th scope="col">{{ __('Updated At') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lantai as $lt)
                                    <tr>
                                        <td>{{ $lt->nama_gedung }}</td>
                                        <td>{{ $lt->nama_lantai }}</td>
                                        <td>{{ $lt->updated_at }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#modalEdit{{ $lt->id_lantai }}" href="#">{{ __('Edit') }}</a>
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#modalDelete{{ $lt->id_lantai }}" href="/admin/gedung/delete/{{ $lt->id_lantai }}" >{{ __('Delete') }}</a>
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
                            {{ $lantai->links() }}
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
                    <h4>Tambah Lantai</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/lantai/store" autocomplete="off">
                    @csrf
                    <div class="pl-lg-1">
                        <div class="form-group">
                            <label class="form-control-label" for="input-name">{{ __('Nama Gedung') }}</label>
                            <select class="form-control" name="nama_gedung" id="provinces" required="">
                                <option value="" disable="true" selected="true">Pilih Gedung</option>
                                @foreach ($gedung as $key => $value)
                                    <option value="{{$value->id_gedung}}">{{ $value->nama_gedung }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-lantai">{{ __('Nama Lantai') }}</label>
                            <input type="text" name="nama_lantai" id="input-lantai" class="form-control form-control-alternative" placeholder="{{ __('Nama Lantai') }}" value="" required>
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

@foreach ($lantai as $lt)
<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $lt->id_lantai }}" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel-title">
                    <h4>Edit Lantai</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/lantai/update/{{ $lt->id_lantai }}" autocomplete="off">
                    @csrf
                    <div class="pl-lg-1">
                        <div class="form-group">
                            <label class="form-control-label" for="input-name">{{ __('Nama Gedung') }}</label>
                            <select class="form-control" name="nama_gedung" id="gedung" required="">
                                <option value="" disable="true" selected="true">Pilih Gedung</option>
                                @foreach ($gedung as $key => $value)
                                    @if ($value->id_gedung == $lt->id_gedung)
                                        <option value="{{$value->id_gedung}}" selected="">{{ $value->nama_gedung }}</option>
                                    @else
                                        <option value="{{$value->id_gedung}}">{{ $value->nama_gedung }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="input-lantai">{{ __('Nama Lantai') }}</label>
                            <input type="text" name="nama_lantai" id="input-lantai" class="form-control form-control-alternative" placeholder="{{ __('Nama Lantai') }}" value="{{ $lt->nama_lantai }}" required>
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

@foreach ($lantai as $lt)
<!-- Modal Delete -->
<div class="modal fade" id="modalDelete{{ $lt->id_lantai }}" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel-title">
                    <h4>Hapus Lantai</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/lantai/delete/{{ $lt->id_lantai }}"> 
                    @csrf
                    <div class="form-group text-center">
                        <label>Apakah Anda Yakin Untuk Menghapus Data Ini ?</label>        
                    </div>
                    <div class="form-group text-center">
                        <label>Menghapus Data Ini Juga Akan Menghapus Data Rak, Perangkat, Dan Port Yang Berkaitan Dengan Data Ini.</label>        
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
@endsection
