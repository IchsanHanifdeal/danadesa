<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;
    protected $table = 'penduduk';
    protected $primaryKey = 'id_penduduk';
    protected $fillable = ['id_user', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat'];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}