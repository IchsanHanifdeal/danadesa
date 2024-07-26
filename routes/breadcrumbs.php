<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

Breadcrumbs::for('penduduk', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Penduduk', route('penduduk'));
});

Breadcrumbs::for('uang_masuk', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Transaksi Masuk', route('uang_masuk'));
});

Breadcrumbs::for('uang_keluar', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Transaksi Keluar', route('uang_keluar'));
});

Breadcrumbs::for('laporan', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Laporan', route('laporan'));
});

Breadcrumbs::for('errors.404', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Error 404 (Not Found)');
});