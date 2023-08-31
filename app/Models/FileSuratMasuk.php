<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSuratMasuk extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function surat_masuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }
}
