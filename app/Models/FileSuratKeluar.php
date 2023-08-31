<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSuratKeluar extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relasi antar Tabel
    public function surat_keluar()
    {
        return $this->belongsTo(SuratKeluar::class);
    }
}
