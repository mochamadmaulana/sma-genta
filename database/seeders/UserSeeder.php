<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'nama_lengkap' => 'Irwan Supriawan Syah S.Pd.',
            'username' => 'irwan',
            'email' => 'irwan.supriawan.syah@example.com',
            'jabatan_id' => '1',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'status' => 'aktif',
            'role' => 'Admin',
            'alamat' => null
        ]);

        $admin2 = User::create([
            'nama_lengkap' => 'Ahmad Supriadi S.Kom.',
            'username' => 'upik',
            'email' => 'ahmad.supriadi@example.com',
            'jabatan_id' => '2',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'status' => 'aktif',
            'role' => 'Admin',
            'alamat' => null
        ]);

        $kepala_sekolah = User::create([
            'nama_lengkap' => 'Fira Ferista S.Pd.',
            'username' => 'fira',
            'email' => 'fira.ferista@example.com',
            'jabatan_id' => '3',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'status' => 'aktif',
            'role' => 'Kepala Sekolah',
            'alamat' => null
        ]);
    }
}
