<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id_user' => '1',
            'foto_profil' => 'default.png',
            'nik' => '123456789',
            'nama_depan' => 'Muhammad Qoirul',
            'nama_belakang' => 'Rodzikin',
            'username' => 'Admin',
            'email' => 'muhammadqoirulrodzikin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        User::create([
            'id_user' => '2',
            'foto_profil' => 'default.png',
            'nik' => '123123',
            'nama_depan' => 'Muhammad Qoirul',
            'nama_belakang' => 'Rodzikin',
            'username' => 'penduduk',
            'email' => 'penduduk@gmail.com',
            'password' => Hash::make('penduduk'),
            'role' => 'user',
        ]);
    }
}
