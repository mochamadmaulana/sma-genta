<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relasi antar Tabel
    public function surat_masuk()
    {
        return $this->hasMany(SuratMasuk::class);
    }

    public function surat_keluar()
    {
        return $this->hasMany(SuratKeluar::class);
    }

    public function file_template_surat()
    {
        return $this->hasMany(FileTemplateSurat::class);
    }
}
