<?php

namespace Database\Seeders;

use App\Models\UangMasuk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UangMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UangMasuk::create([
            'id_uangmasuk' => '1',
            'sumber' => 'penduduk',
            'id_user' => '2',
            'jumlah' => '1000000',
            'bukti_transfer' => 'default.png',
            'keterangan' => 'Dummy',
            'validasi' => 'diterima',
        ]);
        UangMasuk::create([
            'id_uangmasuk' => '2',
            'sumber' => 'penduduk',
            'id_user' => '2',
            'jumlah' => '1000000',
            'bukti_transfer' => 'default.png',
            'keterangan' => 'Dummy',
            'validasi' => 'ditolak',
        ]);
        UangMasuk::create([
            'id_uangmasuk' => '3',
            'sumber' => 'penduduk',
            'id_user' => '2',
            'jumlah' => '1000000',
            'bukti_transfer' => 'default.png',
            'keterangan' => 'Dummy',
            'validasi' => 'menunggu persetujuan',
        ]);
    }
}
