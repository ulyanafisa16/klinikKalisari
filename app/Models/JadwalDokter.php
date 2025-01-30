<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function poli()
    {
        return $this->belongsTo(Poli::class); // Anggap ada model Poli
    }

    // Relasi ke model Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class); // Anggap ada model Dokter
    }

    public function pasien()
    {
    return $this->belongsTo(Pasien::class);
    }
}
