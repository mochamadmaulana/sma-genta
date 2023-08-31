<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nama_lengkap',
        'username',
        'nik_ktp',
        'nip_pegawai',
        'jabatan_id',
        'email',
        'password',
        'aktif',
        'role',
        'photo_profile',
        'photo_ktp',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi antar Tabel
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function surat_masuk()
    {
        return $this->hasMany(SuratMasuk::class);
    }

    public function surat_keluar()
    {
        return $this->hasMany(SuratKeluar::class);
    }
}
