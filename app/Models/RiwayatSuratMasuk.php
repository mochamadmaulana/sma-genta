<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatSuratMasuk extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relasi antar Tabel
    public function surat_masuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }
}
