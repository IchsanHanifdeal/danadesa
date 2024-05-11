<?php

namespace App\Http\Controllers;

use App\Models\UangMasuk;
use App\Models\UangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('uangkeluar', [
            'title' => 'Transaksi Keluar',
            'active' => 'uang_keluar',
            'foto_profil' => $request->session()->get('foto_profil'),
            'id_user' => $request->session()->get('id_user'),
            'nama_depan' => $request->session()->get('nama_depan'),
            'role' => $request->session()->get('role'),
            'nama_belakang' => $request->session()->get('nama_belakang'),
            'uang_keluar' => UangKeluar::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jumlah_Kas_masuk = UangMasuk::where('validasi', 'diterima')->sum('jumlah');
        $jumlah_Kas_keluar = UangKeluar::sum('jumlah');
        $jumlah_Kas = $jumlah_Kas_masuk - $jumlah_Kas_keluar;

        $customMessages = [
            'jumlah.lt' => 'Jumlah harus lebih kecil dari total kas yang tersedia.',
        ];

        $request->validate([
            'tanggal' => 'date|required',
            'keterangan' => 'required',
            'dokumentasi' => 'file|required',
            'jumlah' => 'integer|required|lt:' . $jumlah_Kas,
        ],  $customMessages);

        $dokumentasi_path = null;
        if ($request->file('dokumentasi')) {
            $file_path = $request->file('dokumentasi')->store('public/dokumentasi');
            $dokumentasi_path = str_replace('public/', '', $file_path);
        }
        $uangkeluar = UangKeluar::create([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'dokumentasi' => $dokumentasi_path,
            'jumlah' => $request->jumlah,
        ]);

        if (!$uangkeluar) {
            toastr()->error('Gagal!');
            return redirect()->back();
        }

        toastr()->success('Input Transaksi Keluar berhasil!');
        return redirect()->route('uang_keluar');
    }

    /**
     * Display the specified resource.
     */
    public function show(UangKeluar $uangKeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UangKeluar $uangKeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UangKeluar $uangKeluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UangKeluar $uangKeluar)
    {
        //
    }
}
