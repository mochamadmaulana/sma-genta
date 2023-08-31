<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileTemplateSurat extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relasi antar Tabel
    public function jenis_surat()
    {
        return $this->belongsTo(JenisSurat::class);
    }
}
