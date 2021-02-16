@extends('layouts.user', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'description' => __('This is your profile page. You can see the progress you\'ve made with your work and manage your projects or assigned tasks'),
        'class' => 'col-lg-7'
    ])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('Edit Profile') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">

                                <form method="post" action="/user/profile/update/{{ $user->id }}" autocomplete="off">
                                    <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                                    
                                    @if (session('status'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('status') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    {{ csrf_field() }}
                                    <div class="pl-lg-4">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                            <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ $user->name }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                            <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ $user->email }}" required>

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-center">
                                         <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form method="post" role="form" action="/user/reset-password/{{ $user->id }}" autocomplete="off">
                                    <h6 class="heading-small text-muted mb-4">{{ __('Password') }}</h6>

                                    @if (session('password_status_success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('password_status_success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @elseif (session('password_status_fail'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ session('password_status_fail') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <div class="pl-lg-4">
                                        <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-current-password">{{ __('Current Password') }}</label>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                                            <input type="password" class="form-control form-control-alternative" id="current-password" name="current_password" placeholder="Current Password" required="">
                                            
                                            @if ($errors->has('old_password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('old_password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-password">{{ __('New Password') }}</label>
                                            <input type="password" class="form-control form-control-alternative" id="password" name="password" placeholder="New Password" required="">
                                            
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
                                            <input type="password" class="form-control form-control-alternative" id="password_confirmation" name="password_confirmation" placeholder="Re-enter New Password" required="">
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success mt-4">{{ __('Change password') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
@endsection