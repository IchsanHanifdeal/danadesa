<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('penduduk', [
            'title' => 'Penduduk',
            'active' => 'penduduk',
            'foto_profil' => $request->session()->get('foto_profil'),
            'nama_depan' => $request->session()->get('nama_depan'),
            'nama_belakang' => $request->session()->get('nama_belakang'),
            'role' => $request->session()->get('role'),
            'penduduk' => Penduduk::all(),
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
        DB::beginTransaction();

        try {
            $request->validate([
                'foto_profil' => 'file',
                'nik' => 'required|numeric|unique:users',
                'nama_depan' => 'required|string|max:255',
                'nama_belakang' => 'required|string|max:255',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required|date',
                'alamat' => 'required',
                'password' => 'required',
            ]);

            $foto_profil_path = null;
            if ($request->file('foto_profil')) {
                $file_path = $request->file('foto_profil')->store('public/foto_profil');
                $foto_profil_path = str_replace('public/', '', $file_path);
            }

            $user = User::create([
                'foto_profil' => $foto_profil_path,
                'nik' => $request->nik,
                'nama_depan' => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'user',
            ]);

            if (!$user) {
                toastr()->error('Gagal mendaftarkan User!');
                return redirect()->back();
            }

            $userID = $user->id_user;

            $penduduk = Penduduk::create([
                'id_user' => $userID,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
            ]);

            if (!$penduduk) {
                toastr()->error('Gagal mendaftarkan penduduk!');
                DB::rollBack();
                return redirect()->back();
            }

            DB::commit();

            toastr()->success('Daftar Penduduk berhasil!');
            return redirect()->route('penduduk');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('An error occurred. Please try again later.');
            return redirect()->back();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Penduduk $penduduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penduduk $penduduk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_penduduk)
    {
        DB::beginTransaction();

        try { 
            $penduduk = Penduduk::where('id_penduduk', $id_penduduk)->firstOrFail();
            $user = User::findOrFail($penduduk->id_user);

            $request->validate([
                'foto_profil' => 'file|nullable',
                'nik' => 'required|numeric|unique:users,nik,' . $user->id_user . ',id_user',
                'nama_depan' => 'required|string|max:255',
                'nama_belakang' => 'required|string|max:255',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required|date',
                'alamat' => 'required',
                'password' => 'sometimes|required|min:6',
            ]);

            $foto_profil_path = $user->foto_profil;
            if ($request->file('foto_profil')) {
                $file_path = $request->file('foto_profil')->store('public/foto_profil');
                $foto_profil_path = str_replace('public/', '', $file_path);
            }

            $user->update([
                'foto_profil' => $foto_profil_path,
                'nik' => $request->nik,
                'nama_depan' => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'username' => $request->username,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
                $user->save();
            }

            $penduduk = Penduduk::where('id_penduduk', $id_penduduk)->firstOrFail();

            $penduduk->update([
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
            ]);

            $penduduk->save();

            DB::commit();

            toastr()->success('Update Penduduk berhasil!');
            return redirect()->route('penduduk');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('An error occurred: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id_user)
    {
        $user = User::find($id_user);

        if ($user) {
            $user->delete();

            toastr('Data User dan Penduduk dihapus!', 'success');
        } else {
            toastr('Data tidak ditemukan!', 'error');
        }

        return redirect()->route('penduduk');
    }
}
