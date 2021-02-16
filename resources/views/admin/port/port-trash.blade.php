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
                                <h3 class="mb-0">{{ __('Data Sampah Port') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="/admin/port" class="btn btn-sm btn-primary">{{ __('Port') }}</a>
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
                                <th scope="col">{{ __('Nama Perangkat') }}</th>
                                <th scope="col">{{ __('Nama Port') }}</th>
                                <th scope="col">{{ __('Deleted At') }}</th>
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
                                <td>{{ $p->deleted_at }}</td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" onClick="return confirm('Kembalikan Data Ini ?')" href="/admin/port/kembalikan/{{ $p->id_port }}/{{ $p->id_perangkat }}" >{{ __('Restore') }}</a>
                                            <a class="dropdown-item" data-toggle="modal" data-target="#modalDelete{{ $p->id_port }}" href="#">{{ __('Force Delete') }}</a>
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
                <form method="post" action="/admin/port/hapus_permanen/{{ $r->id_port }}">
                    @csrf
                    <div class="form-group text-center">
                        <label>Apakah Anda Yakin Untuk Menghapus Permanen Data Ini ?</label>
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
