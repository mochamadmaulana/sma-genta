<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relasi antar Tabel
    public function file_surat_keluar()
    {
        return $this->hasMany(FileSuratKeluar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenis_surat()
    {
        return $this->belongsTo(JenisSurat::class);
    }
}
