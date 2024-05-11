<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\UangMasuk;
use App\Models\UangKeluar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $jumlah_penduduk = Penduduk::count();
        $jumlah_Transaksi = UangMasuk::count();
        $jumlah_TransaksiKeluar = UangKeluar::count();
        $jumlah_Kas_masuk = UangMasuk::where('validasi', 'diterima')->sum('jumlah');
        $jumlah_Kas_keluar = UangKeluar::sum('jumlah');
        $jumlah_Kas = $jumlah_Kas_masuk - $jumlah_Kas_keluar;
        $formatted_jumlah_Kas_masuk = "Rp " . number_format($jumlah_Kas_masuk, 2, ',', '.');
        $formatted_jumlah_Kas_keluar = "Rp " . number_format($jumlah_Kas_keluar, 2, ',', '.');
        $formatted_jumlah_Kas = "Rp " . number_format($jumlah_Kas, 2, ',', '.');

        return view('dashboard', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'foto_profil' => $request->session()->get('foto_profil'),
            'nama_depan' => $request->session()->get('nama_depan'),
            'nama_belakang' => $request->session()->get('nama_belakang'),
            'role' => $request->session()->get('role'),
            'total_penduduk' => $jumlah_penduduk,
            'total_transaksi_masuk' => $jumlah_Transaksi,
            'total_transaksi_keluar' => $jumlah_TransaksiKeluar,
            'total_transaksi_masuk_uang' => $formatted_jumlah_Kas_masuk,
            'total_transaksi_keluar_uang' => $formatted_jumlah_Kas_keluar,
            'jumlahkas' => $formatted_jumlah_Kas,
        ]);
    }
}
