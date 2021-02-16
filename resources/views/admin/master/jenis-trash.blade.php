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
                                <h3 class="mb-0">{{ __('Nama Perangkat') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="/admin/jenis" class="btn btn-sm btn-primary">{{ __('Perangkat') }}</a>
                                <a href="/admin/jenis/kembalikan_semua" class="btn btn-sm btn-primary" onClick="return confirm('Restore Seluruh Data ?')">{{ __('Restore All') }}</a>
                                <a href="/admin/jenis/hapus_permanen_semua" class="btn btn-sm btn-primary" onClick="return confirm('Hapus Permanen Semua Data ?')">{{ __('Delete All') }}</a>
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
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Deleted Date') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jenis as $jns)
                                    <tr>
                                        <td>{{ $jns->nama }}</td>
                                        <td>{{ $jns->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" onClick="return confirm('Kembalikan Data Ini ?')" href="/admin/jenis/kembalikan/{{ $jns->id }}" >{{ __('Restore') }}</a>
                                                    <a class="dropdown-item" onClick="return confirm('Hapus Permanen Data Ini ?')" href="/admin/jenis/hapus_permanen/{{ $jns->id }}" >{{ __('Force Delete') }}</a>
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
@endsection
