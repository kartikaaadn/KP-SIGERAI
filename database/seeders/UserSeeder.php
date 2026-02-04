<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Perusahaan;
use App\Models\Mahasiswa;
use App\Models\Penempatan;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        $perusahaanUser = User::create([
            'name' => 'PT Teknologi Hebat',
            'email' => 'perusahaan@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'perusahaan',
        ]);

        $company = Perusahaan::create([
            'nama' => 'PT Teknologi Hebat',
            'alamat' => 'Jl. Pahlawan No. 42, Kemiling',
            'pic' => 'Dwi Sakethi',
            'kontak' => '081234567890',
            'owner_user_id' => $perusahaanUser->id,
        ]);

        $mhsUser = User::create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'mahasiswa',
        ]);

        $mahasiswa = Mahasiswa::create([
            'user_id' => $mhsUser->id,
            'npm' => '22000001',
            'nama' => 'Mahasiswa Contoh',
            'jurusan' => 'Informatika',
            'angkatan' => 2022,
            'kontak_pribadi' => '085700000000',
        ]);

        Penempatan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'perusahaan_id' => $company->id,
            'mulai' => now()->toDateString(),
            'selesai' => null,
        ]);
    }
}
