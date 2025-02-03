<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poli extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function jadwalDokters()
    {
        return $this->hasMany(JadwalDokter::class);
    }

    public function pasiens(): HasMany
    {
        return $this->hasMany(Pasien::class, 'dokter_id'); // Menambahkan relasi ke pasien
    }
    public function dokters(): HasMany
    {
        return $this->hasMany(Dokter::class, 'poli_id'); // Relasi antara Poli dan Dokter
    }

    public function administrasi(): HasMany
    {
        return $this->hasMany(Administrasi::class);
    }

}
