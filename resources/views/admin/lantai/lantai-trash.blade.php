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
                                <h3 class="mb-0">{{ __('Data Sampah Lantai') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="/admin/lantai" class="btn btn-sm btn-primary">{{ __('Lantai') }}</a>
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
                                                    <a class="dropdown-item" onClick="return confirm('Kembalikan Data Ini ?')" href="/admin/lantai/kembalikan/{{ $lt->id_lantai }}/{{ $lt->id_gedung }}" >{{ __('Restore') }}</a>
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#modalDelete{{ $lt->id_lantai }}" href="/admin/gedung/delete/{{ $lt->id_lantai }}" >{{ __('Force Delete') }}</a>
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
                <form method="post" action="/admin/lantai/hapus_permanen/{{ $lt->id_lantai }}"> 
                    @csrf
                    <div class="form-group text-center">
                        <label>Apakah Anda Yakin Untuk Menghapus Permanen Data Ini ?</label>        
                    </div>
                    <div class="form-group text-center">
                        <label>Menghapus Permanen Data Ini Juga Akan Menghapus Data Rak, Perangkat, Dan Port Yang Berkaitan Dengan Data Ini.</label>        
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
