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
        $month = $request->input('month');
        $filter_sumber = $request->input('sumber'); // penduduk/pemerintah

        $isFiltered = !empty($month);

        $uang_masuk_query = UangMasuk::where('validasi', 'diterima');

        if ($isFiltered) {
            $uang_masuk_query->whereMonth('created_at', '=', date('m', strtotime($month)))
                ->whereYear('created_at', '=', date('Y', strtotime($month)));
        }

        if ($filter_sumber) {
            $uang_masuk_query->where('sumber', $filter_sumber);
        }

        $uang_masuk = $uang_masuk_query->select('created_at as tanggal', 'keterangan', 'jumlah', 'bukti_transfer', 'sumber')->get();

        $uang_keluar_query = UangKeluar::query();

        if ($isFiltered) {
            $uang_keluar_query->whereMonth('tanggal', '=', date('m', strtotime($month)))
                ->whereYear('tanggal', '=', date('Y', strtotime($month)));
        }

        $uang_keluar = $uang_keluar_query->select('tanggal', 'keterangan', 'jumlah', 'dokumentasi')->get();

        $data = $uang_masuk->map(function ($item) {
            return [
                'tanggal' => $item->tanggal,
                'kategori' => 'Pemasukan (' . ucfirst($item->sumber) . ')',
                'keterangan' => $item->keterangan,
                'pemasukan' => $item->jumlah,
                'pengeluaran' => null,
                'dokumentasi' => $item->bukti_transfer, // Bukti transfer sebagai dokumentasi
            ];
        })->merge($uang_keluar->map(function ($item) {
            return [
                'tanggal' => $item->tanggal,
                'kategori' => 'Pengeluaran',
                'keterangan' => $item->keterangan,
                'pemasukan' => null,
                'pengeluaran' => $item->jumlah,
                'dokumentasi' => $item->dokumentasi, // Dokumentasi untuk pengeluaran
            ];
        }));

        $total_pemasukan = $uang_masuk->sum('jumlah');
        $total_pengeluaran = $uang_keluar->sum('jumlah');
        $saldo = $total_pemasukan - $total_pengeluaran;

        return view('laporan', [
            'title' => 'Laporan',
            'active' => 'laporan',
            'data' => $data,
            'month' => $month,
            'total_pemasukan' => $total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
            'saldo' => $saldo,
            'isFiltered' => $isFiltered,
            'foto_profil' => $request->session()->get('foto_profil'),
            'nama_depan' => $request->session()->get('nama_depan'),
            'nama_belakang' => $request->session()->get('nama_belakang'),
            'filter_sumber' => $filter_sumber,
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
