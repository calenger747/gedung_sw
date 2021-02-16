@extends('layouts.admin')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
        <div class="row">
        <div class="col md-12">
          <div class="card">
            <div class="card-header bg-transparent border-0">
              <h3 class="mb-0">About This Website</h3>
            </div>
            <div class="card-body">
                <div class="stream-headline">
                    <h1 style="text-align: center; font-family: Script MT; font-size: 44px;">
                        Gedung S.W
                    </h1>
                </div>
                <div class="stream-text">
                    Gedung S.W (Gedung Search Website)
                    is a website-based application that is intended to help someone when looking for a building,
                    This application was created by PT. Lumbung Riang in 2019, with the existence of this website, hopefully the users will be easier to get to know
                </div>
            </div>
          </div>
        </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
