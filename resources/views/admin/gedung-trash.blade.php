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
                                <h3 class="mb-0">{{ __('Data Sampah Gedung') }}</h3>
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
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Kota') }}</th>
                                    <th scope="col">{{ __('Kontak') }}</th>
                                    <th scope="col">{{ __('Jam Operasional') }}</th>
                                    <th scope="col">{{ __('Kunci') }}</th>
                                    <th scope="col">{{ __('Deleted At') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gedung as $gdg)
                                    <tr>
                                        <td>{{ $gdg->nama_gedung }}</td>
                                        <td>{{ $gdg->name_kab }}</td>
                                        <td>{{ $gdg->kontak }}</td>
                                        <td>{{ $gdg->jam_buka }} - {{ $gdg->jam_tutup }}</td>
                                        <td>{{ $gdg->kunci }}</td>
                                        <td>{{ $gdg->deleted_at }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <!-- <a class="dropdown-item" data-toggle="modal" data-target="#modalUpload{{ $gdg->id_gedung }}" href="/admin/gedung/upload/{{ $gdg->id_gedung }}" >{{ __('Add Gambar') }}</a> -->
                                                    <a class="dropdown-item" onClick="return confirm('Kembalikan Data Ini ?')" href="/admin/gedung/kembalikan/{{ $gdg->id_gedung }}" >{{ __('Restore') }}</a>
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#modalDelete{{ $gdg->id_gedung }}" href="/admin/gedung/delete/{{ $gdg->id_gedung }}" >{{ __('Force Delete') }}</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @include('layouts.footers.auth')
    </div>
@foreach ($gedung as $gdg)
<!-- Modal Delete -->
<div class="modal fade" id="modalDelete{{ $gdg->id_gedung }}" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel-title">
                    <h4>Hapus Permanen Gedung</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/gedung/hapus_permanen/{{ $gdg->id_gedung }}"> 
                    @csrf
                    <div class="form-group text-center">
                        <label>Apakah Anda Yakin Untuk Menghapus Permanen Data Ini ?</label>        
                    </div>
                    <div class="form-group text-center">
                        <label>Menghapus Permanen Data Ini Juga Akan Menghapus Data Lantai, Rak, Perangkat, Dan Port Yang Berkaitan Dengan Data Ini.</label>        
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
