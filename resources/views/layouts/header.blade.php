<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | {{ $title }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('temp/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('temp/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('storage/' . $foto_profil) }}" class="img-circle elevation-2"
                            alt="{{ $nama_depan . ' ' . $nama_belakang }}">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ $nama_depan . ' ' . $nama_belakang }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route ('dashboard') }}" class="nav-link {{ $active === 'dashboard' ? ' active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        @if ($role == 'admin')
                        <li class="nav-item">
                            <a href="{{ route('penduduk') }}" class="nav-link {{ $active === 'penduduk' ? ' active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Penduduk
                                </p>
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('uang_masuk')}}" class="nav-link {{ $active === 'uang_masuk' ? ' active' : '' }}">
                                <i class="nav-icon fas fa-money-bill"></i>
                                <p>
                                    Transaksi Masuk
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('uang_keluar') }}" class="nav-link {{ $active === 'uang_keluar' ? ' active' : '' }}">
                                <i class="nav-icon fas fa-money-bill"></i>
                                <p>
                                    Transaksi Keluar
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporan') }}" class="nav-link {{ $active === 'laporan' ? ' active' : '' }}">
                                <i class="nav-icon fas fa-archive"></i>
                                <p>
                                    Laporan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <a href="#" class="nav-link"
                                    onclick="event.preventDefault(); confirmLogout();">
                                    <i class="nav-icon fas fa-power-off"></i>
                                  <p>Log out</p>
                                </a>
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">{{ config('app.name') }} | {{ $title }}</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                {{ Breadcrumbs::render() }}
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
