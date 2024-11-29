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
@if (Auth::user()->veritifikasi === 'menunggu persetujuan')
    <div class="d-flex flex-column align-items-center justify-content-center vh-100 bg-light">
        <a href="#" class="d-flex align-items-center mb-4 text-decoration-none text-primary">
            <i class="fas fa-award fa-2x me-2"></i>
            <span class="h4 fw-bold">{{ config('app.name') }}</span>
        </a>
        <div class="card shadow border-0" style="max-width: 400px; width: 100%;">
            <div class="card-body p-5 text-center">
                <h1 class="h4 fw-bold text-uppercase mb-4 text-dark">
                    Menunggu Persetujuan Admin
                </h1>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
@elseif(Auth::user()->veritifikasi === 'ditolak')
    <div class="d-flex flex-column align-items-center justify-content-center vh-100 bg-light">
        <a href="#" class="d-flex align-items-center mb-4 text-decoration-none text-primary">
            <i class="fas fa-award fa-2x me-2"></i>
            <span class="h4 fw-bold">{{ config('app.name') }}</span>
        </a>
        <div class="card shadow border-0" style="max-width: 400px; width: 100%;">
            <div class="card-body p-5 text-center">
                <h1 class="h4 fw-bold text-uppercase mb-4 text-dark">
                    Veritifikasi Anda ditolak
                </h1>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
@else
    @include('layouts.header')

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $jumlahkas }}</h3>

                            <p>Jumlah Kas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $total_transaksi_masuk_uang }}</h3>

                            <p>Kas Masuk</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $total_transaksi_keluar_uang }}</h3>

                            <p>Kas Keluar</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill"></i>
                        </div>
                    </div>
                </div>
                @if ($role == 'admin')
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $total_penduduk }}</h3>

                                <p>Jumlah Penduduk</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <a href="{{ route('penduduk') }}" class="small-box-footer">Info lainnya <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $total_transaksi_masuk }}</h3>

                                <p>Jumlah Transaksi Masuk</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-bill"></i>
                            </div>
                            <a href="{{ route('uang_masuk') }}" class="small-box-footer">Info lainnya <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $total_transaksi_keluar }}</h3>

                                <p>Jumlah Transaksi Keluar</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-bill"></i>
                            </div>
                            <a href="{{ route('uang_keluar') }}" class="small-box-footer">Info lainnya <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <!-- Control Sidebar -->

    @include('layouts.footer')
@endif
