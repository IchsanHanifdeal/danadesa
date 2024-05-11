<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UangKeluar extends Model
{
    use HasFactory;
    protected $table = 'uang_keluar';
    protected $primaryKey = 'id_uangkeluar';
    protected $fillable = ['tanggal', 'keterangan', 'dokumentasi', 'jumlah'];
}
