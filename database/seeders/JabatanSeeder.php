<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kepala_tu = Jabatan::create([
            'nama_jabatan' => 'Kepala TU'
        ]);
        $staff_tu = Jabatan::create([
            'nama_jabatan' => 'Staff TU'
        ]);
        $kepala_sekolah = Jabatan::create([
            'nama_jabatan' => 'Kepala Sekolah'
        ]);
    }
}
