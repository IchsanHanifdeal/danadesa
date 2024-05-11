@php
    $title = 'Error 404';
    $foto_profil = 'Error 404';
    $nama_depan = 'Error 404';
    $nama_belakang = 'Error 404';
    $active = 'error 404';
@endphp
@include('layouts.header')
<!-- Main content -->
<section class="content">
    <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Halaman tidak ditemukan.</h3>

            <p>
                We could not find the page you were looking for.
                Meanwhile, you may <a href="{{ route('dashboard')}}">return to dashboard</a> or try using the search form.
            </p>

        </div>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
</section>
@include('layouts.footer')
