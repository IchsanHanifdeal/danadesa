<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $userRole = Auth::user()->role;

            if ($userRole == 'admin') {
                $request->session()->regenerate();
                $user = Auth::user();
                $request->session()->put('id_user', $user->id_user);
                $request->session()->put('foto_profil', $user->foto_profil);
                $request->session()->put('nama_depan', $user->nama_depan);
                $request->session()->put('nama_belakang', $user->nama_belakang);
                $request->session()->put('role', $user->role);
                return redirect()->intended('dashboard')->with('success', 'Login berhasil!');
            } elseif ($userRole == 'user') {
                $request->session()->regenerate();
                $user = Auth::user();
                $request->session()->put('id_user', $user->id_user);
                $request->session()->put('foto_profil', $user->foto_profil);
                $request->session()->put('nama_depan', $user->nama_depan);
                $request->session()->put('nama_belakang', $user->nama_belakang);
                $request->session()->put('role', $user->role);
                return redirect()->intended('dashboard')->with('success', 'Login berhasil!');
            }

            return back()->with('loginError', 'Login gagal, peran pengguna tidak dikenali.');
        }

        toastr()->error('NIK atau password salah.');

        return back()->withErrors([
            'loginError' => 'NIK atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toastr()->success('Logout berhasil, Anda telah keluar');

        return redirect('/');
    }
}
