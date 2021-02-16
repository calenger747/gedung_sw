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
                                <h3 class="mb-0">{{ __('Data Gedung') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="/admin/tambah-gedung" class="btn btn-sm btn-primary">{{ __('Add gedung') }}</a>
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
                                    <th scope="col">{{ __('Kota') }}</th>
                                    <th scope="col">{{ __('Kontak') }}</th>
                                    <th scope="col">{{ __('Jam Operasional') }}</th>
                                    <th scope="col">{{ __('Kunci') }}</th>
                                    <th scope="col">{{ __('Updated At') }}</th>
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
                                        <td>{{ $gdg->updated_at }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#modalUpload{{ $gdg->id_gedung }}" href="/admin/gedung/upload/{{ $gdg->id_gedung }}" >{{ __('Add Gambar') }}</a>
                                                    <a class="dropdown-item" href="/admin/update-gedung/{{ $gdg->id_gedung }}">{{ __('Edit') }}</a>
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#modalDelete{{ $gdg->id_gedung }}" href="/admin/gedung/delete/{{ $gdg->id_gedung }}" >{{ __('Delete') }}</a>
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
                            {{ $gedung->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@foreach ($gedung as $gdg)
<!-- Modal Upload -->
<div class="modal fade" id="modalUpload{{ $gdg->id_gedung }}" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true" style="position: absolute;top:100px">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel-title">
                    <h4>Add Gambar Gedung</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/gedung/upload/{{ $gdg->id_gedung }}" enctype="multipart/form-data"> 
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="form-control-label" for="input-name">{{ __('Nama Gedung') }}</label>
                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative" placeholder="{{ __('Nama Gedung') }}" value="{{ $gdg->nama_gedung }}" required readonly="">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="id_gedung" value="{{ $gdg->id_gedung }}">
                        <label class="form-control-label" for="input-name">{{ __('Gambar Gedung') }}</label>
                        <input type="file" name="gambar" id="input-name" class="form-control gambar form-control-alternative" placeholder="{{ __('Gambar') }}" value="" required="">
                    </div>
                    <div class="text-center modal-footer">
                        <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach ($gedung as $gdg)
<!-- Modal Delete -->
<div class="modal fade" id="modalDelete{{ $gdg->id_gedung }}" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true" style="position: absolute;top:100px">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel-title">
                    <h4>Hapus Gedung</h4>
                </div>
                <button aria-hidden="true" data-dismiss="modal" class="close right" type="button">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/gedung/delete/{{ $gdg->id_gedung }}"> 
                    @csrf
                    <div class="form-group text-center">
                        <label>Apakah Anda Yakin Untuk Menghapus Data Ini ?</label>        
                    </div>
                    <div class="form-group text-center">
                        <label>Menghapus Data Ini Juga Akan Menghapus Data Lantai, Rak, Perangkat, Dan Port Yang Berkaitan Dengan Data Ini.</label>        
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

$(document).ready(function() {
    $('#example').DataTable();
} );

</script>
@endsection
