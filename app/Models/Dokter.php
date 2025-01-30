<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dokter extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function administrasi(): HasMany
    {
        return $this->hasMany(Administrasi::class);
    }

    public function jadwalDokters()
    {
        return $this->hasMany(JadwalDokter::class);
    }
    
    public function pasiens(): HasMany
    {
        return $this->hasMany(Pasien::class, 'dokter_id'); // Menambahkan relasi ke pasien
    }

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class, 'poli_id'); // Menentukan foreign key (poli_id)
    }

}
