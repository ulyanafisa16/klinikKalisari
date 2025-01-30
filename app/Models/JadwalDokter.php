<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'jadwal_dokters'; 

    public function poli()
    {
        return $this->belongsTo(Poli::class); // Anggap ada model Poli
    }

    // Relasi ke model Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id'); // Anggap ada model Dokter
    }

    public function pasien()
    {
    return $this->belongsTo(Pasien::class);
    }
}
