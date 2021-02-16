<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="/admin">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="/admin/profile" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="/logout" class="dropdown-item">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="/admin">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/admin">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/gedung">
                        <i class="fa fa-building text-blue"></i> {{ __('Data Gedung') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/admin/lantai">
                        <i class="ni ni-building text-blue"></i> {{ __('Lantai') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/rak">
                        <i class="ni ni-box-2 text-orange"></i> {{ __('Rak') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/perangkat">
                        <i class="ni ni-mobile-button text-info"></i> {{ __('Perangkat') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/port">
                        <i class="ni ni-ui-04 text-info"></i> {{ __('Port') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#modalCari">
                        <i class="fa fa-search text-info"></i> {{ __('Cari Data') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button">
                        <i class="fa fa-trash" style="color: #f4645f;"></i>
                        <span class="nav-link-text">{{ __('Trash') }}</span>
                    </a>

                    <div class="collapse" id="navbar-examples">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/gedung/trash">
                                    {{ __('Gedung') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/lantai/trash">
                                    {{ __('Lantai') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/rak/trash">
                                    {{ __('Rak') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/perangkat/trash">
                                    {{ __('Perangkat') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/port/trash">
                                    {{ __('Port') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/jenis/trash">
                                    {{ __('Jenis Perangkat') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <h6 class="navbar-heading text-muted">Master</h6>
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="/admin/jenis">
                        {{ __('Jenis Perangkat') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/users">
                        {{ __('User Management') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>