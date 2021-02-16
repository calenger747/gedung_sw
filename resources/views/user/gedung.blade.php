@extends('layouts.user')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h3 class="mb-0">{{ __('Data Gedung') }}</h3>
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
