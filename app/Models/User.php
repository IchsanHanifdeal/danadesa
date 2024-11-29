<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $fillable = ['foto_profil', 'nik', 'nama_depan', 'nama_belakang', 'email', 'password', 'role', 'veritifikasi'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::deleting(function ($user) {
            // Hapus data penduduk terkait
            $penduduk = Penduduk::where('id_user', $user->id)->first();
            if ($penduduk) {
                // Hapus foto profil jika ada
                if ($penduduk->foto_profil && Storage::exists($penduduk->foto_profil)) {
                    Storage::delete($penduduk->foto_profil);
                }
                // Hapus data penduduk
                $penduduk->delete();
            }
        });
    }
}
