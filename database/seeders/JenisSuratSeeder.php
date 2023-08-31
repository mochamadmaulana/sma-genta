<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dinas = JenisSurat::create([
            'nama_jenis' => 'Dinas'
        ]);
        $umum_biasa = JenisSurat::create([
            'nama_jenis' => 'Umum/Biasa'
        ]);
        $yayasan = JenisSurat::create([
            'nama_jenis' => 'Yayasan'
        ]);
    }
}
