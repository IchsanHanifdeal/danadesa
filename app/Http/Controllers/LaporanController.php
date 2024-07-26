<?php

namespace App\Http\Controllers;

use App\Models\UangMasuk;
use App\Models\UangKeluar;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $isFiltered = !empty($start_date) && !empty($end_date);

        $uang_masuk = UangMasuk::where('validasi', 'diterima')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->select('created_at as tanggal', 'keterangan', 'jumlah', 'validasi', 'sumber')
            ->get();

        $uang_keluar = UangKeluar::whereBetween('tanggal', [$start_date, $end_date])
            ->select('tanggal', 'keterangan', 'jumlah')
            ->get();

        $data = $uang_masuk->map(function ($item) {
            return [
                'tanggal' => $item->tanggal,
                'kategori' => 'Pemasukan',
                'keterangan' => $item->keterangan,
                'pemasukan' => $item->jumlah,
                'pengeluaran' => null
            ];
        })->merge($uang_keluar->map(function ($item) {
            return [
                'tanggal' => $item->tanggal,
                'kategori' => 'Pengeluaran',
                'keterangan' => $item->keterangan,
                'pemasukan' => null,
                'pengeluaran' => $item->jumlah
            ];
        }));

        $total_pemasukan = $uang_masuk->sum('jumlah');
        $total_pengeluaran = $uang_keluar->sum('jumlah');
        $saldo = $total_pemasukan - $total_pengeluaran;

        return view('laporan', [
            'title' => 'Laporan',
            'active' => 'laporan',
            'data' => $data,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total_pemasukan' => $total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
            'saldo' => $saldo,
            'isFiltered' => $isFiltered,
            'foto_profil' => $request->session()->get('foto_profil'),
            'nama_depan' => $request->session()->get('nama_depan'),
            'nama_belakang' => $request->session()->get('nama_belakang'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function filter(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
