<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JadwalController extends Controller
{public function index()
    {
        $data['jadwal_dokter'] = \App\Models\JadwalDokter::latest()->get();
        $data['judul'] = 'Jadwal Dokter';
        return view('jadwal_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['dokters'] = \App\Models\Dokter::get();
        $data['polis'] = \App\Models\Poli::get();
        return view('jadwal_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasiData = $request->validate([
            'dokter_id' => 'required',
            'poli_id' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);
    
        // Ambil jadwal dokter terakhir untuk membuat kode baru
        $kodeJd = \App\Models\JadwalDokter::orderBy('id', 'desc')->first();
        $kode = 'JD0001'; // Default kode jika tidak ada jadwal sebelumnya
        if ($kodeJd) {
            $kode = 'JD' . sprintf('%04d', $kodeJd->id + 1); // Kode baru berdasarkan urutan
        }
    
        // Membuat instance jadwal baru
        $jadwal = new \App\Models\JadwalDokter();
        $jadwal->kode_jadwal = $kode; // Kode jadwal
        $jadwal->poli_id = $request->poli_id; // Poli ID
        $jadwal->dokter_id = $request->dokter_id; // Dokter ID
        $jadwal->hari = $request->hari; // Hari yang dipilih
        $jadwal->jam_mulai = $request->jam_mulai; // Jam mulai
        $jadwal->jam_selesai = $request->jam_selesai; // Jam selesai
        $jadwal->save(); 
        
        flash('Data sudah disimpan')->success();
        return back();

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}


