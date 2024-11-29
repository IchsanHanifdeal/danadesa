<?php

namespace App\Http\Controllers;

use App\Models\UangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $uangMasukData = Auth::user()->role === 'admin'
        ? UangMasuk::all()  
        : UangMasuk::where(function ($query) {
            $query->where('id_user', Auth::user()->id_user) 
                  ->where('sumber', 'penduduk');
                //   ->orWhere('sumber', 'pemerintah');
        })->get();

    return view('uangmasuk', [
        'title' => 'Transaksi Masuk',
        'active' => 'uang_masuk',
        'foto_profil' => $request->session()->get('foto_profil'),
        'id_user' => $request->session()->get('id_user'),
        'nama_depan' => $request->session()->get('nama_depan'),
        'role' => $request->session()->get('role'),
        'nama_belakang' => $request->session()->get('nama_belakang'),
        'uang_masuk' => $uangMasukData,  // Pass the data to the view
    ]);
    }    

    /**
     * Show the form for creating a new resource.
     */
    public function store_penduduk(Request $request)
    {
        $request->validate([
            'sumber' => 'required',
            'id_user' => 'required',
            'jumlah' => 'integer|required',
            'bukti_transfer' => 'file|required',
            'keterangan' => 'required',
        ]);

        $bukti_transfer_path = null;
        if ($request->file('bukti_transfer')) {
            $file_path = $request->file('bukti_transfer')->store('public/bukti_transfer');
            $bukti_transfer_path = str_replace('public/', '', $file_path);
        }

        $uangmasuk = UangMasuk::create([
            'sumber' => $request->sumber,
            'id_user' => $request->id_user,
            'jumlah' => $request->jumlah,
            'bukti_transfer' => $bukti_transfer_path,
            'keterangan' => $request->keterangan,
            'validasi' => 'menunggu persetujuan',
        ]);

        if (!$uangmasuk) {
            toastr()->error('Gagal!');
            return redirect()->back();
        }

        toastr()->success('Input Uang masuk berhasil!');
        return redirect()->route('uang_masuk');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sumber' => 'required',
            'jumlah' => 'integer|required',
            'bukti_transfer' => 'file|required',
            'keterangan' => 'required',
        ]);

        $bukti_transfer_path = null;
        if ($request->file('bukti_transfer')) {
            $file_path = $request->file('bukti_transfer')->store('public/bukti_transfer');
            $bukti_transfer_path = str_replace('public/', '', $file_path);
        }

        $uangmasuk = UangMasuk::create([
            'sumber' => $request->sumber,
            'jumlah' => $request->jumlah,
            'bukti_transfer' => $bukti_transfer_path,
            'keterangan' => $request->keterangan,
            'validasi' => 'diterima',
        ]);

        if (!$uangmasuk) {
            toastr()->error('Gagal!');
            return redirect()->back();
        }

        toastr()->success('Input Uang masuk berhasil!');
        return redirect()->route('uang_masuk');
    }

    /**
     * Display the specified resource.
     */
    public function tolak(Request $request, $id_uangmasuk)
    {
        $uangMasuk = UangMasuk::findOrFail($id_uangmasuk);
        $uangMasuk->validasi = 'ditolak';
        $uangMasuk->save();

        return back()->with('success', 'Transfer telah ditolak.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_uangmasuk)
    {
        $uangMasuk = UangMasuk::findOrFail($id_uangmasuk);
        $uangMasuk->validasi = 'diterima';
        $uangMasuk->save();

        return back()->with('success', 'Transfer telah diterima.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UangMasuk $uangMasuk)
    {
        //
    }
}
