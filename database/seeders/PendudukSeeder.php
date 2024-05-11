<?php

namespace Database\Seeders;

use App\Models\Penduduk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penduduk::create([
            'id_penduduk' => '1',
            'id_user' => '2',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Batusangkar',
            'tanggal_lahir' => '2002/09/30',
            'alamat' => 'Pekanbaru',
        ]);
    }
}
