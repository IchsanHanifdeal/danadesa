<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UangMasuk extends Model
{
    use HasFactory;
    protected $table = 'uang_masuk';
    protected $primaryKey = 'id_uangmasuk';
    protected $fillable = ['sumber', 'id_user', 'jumlah', 'bukti_transfer', 'keterangan', 'validasi'];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
