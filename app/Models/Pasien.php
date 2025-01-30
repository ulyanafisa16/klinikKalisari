<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pasien extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');  // Relasi ke Dokter
    }
    public function administrasi(): HasMany
    {
        return $this->hasMany(Administrasi::class);
    }

    public function poli()
    {
    return $this->belongsTo(Poli::class, 'poli_id');
    }

    public function jadwalDokter(): BelongsTo
    {
        return $this->belongsTo(JadwalDokter::class, 'jadwal_id');
    }

}
