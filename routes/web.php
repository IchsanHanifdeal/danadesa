<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UangMasukController;
use App\Http\Controllers\UangKeluarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/', [LoginController::class, 'auth'])->name('auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/dashboard/penduduk', [PendudukController::class, 'index'])->name('penduduk');
Route::post('/dashboard/penduduk', [PendudukController::class, 'store'])->name('store_penduduk');
Route::delete('/dashboard/penduduk/{id_user}', [PendudukController::class, 'destroy'])->name('destroy_penduduk');
Route::put('/dashboard/penduduk/{id_penduduk}', [PendudukController::class, 'update'])->name('update_penduduk');

Route::get('/dashboard/uangmasuk', [UangMasukController::class, 'index'])->name('uang_masuk');
Route::post('/dashboard/uangmasuk/store', [UangMasukController::class, 'store'])->name('store_uangmasuk');
Route::post('/dashboard/uangmasuk/penduduk_store', [UangMasukController::class, 'store_penduduk'])->name('pendudukstore_uangmasuk');
Route::put('/dashboard/uangmasuk/{id_uangmasuk}/update', [UangMasukController::class, 'update'])->name('update_uangmasuk');
Route::put('/dashboard/uangmasuk/{id_uangmasuk}/tolak', [UangMasukController::class, 'tolak'])->name('tolak_uangmasuk');

Route::get('/dashboard/uangkeluar', [UangKeluarController::class, 'index'])->name('uang_keluar');
Route::post('/dashboard/uangkeluar', [UangKeluarController::class, 'store'])->name('store_uangkeluar');