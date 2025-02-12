<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrasiPasienController extends Controller
{

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['list_jk'] = [
            'Pria' => 'Pria',
            'Wanita' => 'Wanita'
        ];
        $data['dokter'] = \App\Models\Dokter::all();
        $data['poli'] = \App\Models\Poli::all();
        $data['jadwal'] = \App\Models\JadwalDokter::all();
        return view('registrasipasien_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi inputan
        $validasiData = $request->validate([
            'nama_pasien' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'nomor_hp' => 'required',
            'dokter_id' => 'required|exists:dokters,id',
            'alamat' => 'required',
            'nik' => 'required|digits:16|unique:pasiens,nik', 
            'poli_id' => 'required|exists:polis,id', // Validasi poli
            'jadwal_id' => 'required|exists:jadwal_dokters,id', // Validasi jadwal
            'jam_kunjungan' => 'required|date_format:H:i',
            'tipe_pemeriksaan' => 'required|in:Klinik,Homecare',
        ]);
        try {
            DB::beginTransaction();
        
            // Proses penyimpanan data pasien
            $kodeQuery = \App\Models\Pasien::orderBy('id', 'desc')->first();
            $kode = 'P0001';
            if ($kodeQuery) {
                $kode = 'P' . sprintf('%04d', $kodeQuery->id + 1);
            }
        
            $pasien = new \App\Models\Pasien();
            $pasien->kode_pasien = $kode;
            $pasien->nama_pasien = $request->nama_pasien;
            $pasien->jenis_kelamin = $request->jenis_kelamin;
            $pasien->status = $request->status ?? 'Aktif';
            $pasien->alamat = $request->alamat;
            $pasien->tipe_pemeriksaan = $request->tipe_pemeriksaan;
            $pasien->jam_kunjungan = $request->jam_kunjungan;
            $pasien->jadwal_id = $request->jadwal_id;
            $pasien->nik = $request->nik;
            $pasien->poli_id = $request->poli_id;
            $pasien->dokter_id = $request->dokter_id;
            $pasien->nomor_hp = $request->nomor_hp;
            $pasien->save();
        
            // Proses penyimpanan administrasi
            $kodeAdm = \App\Models\Administrasi::orderBy('id', 'desc')->first();
            $kode = 'ADM0001';
            if ($kodeAdm) {
                $kode = 'ADM' . sprintf('%04d', $kodeAdm->id + 1);
            }
        
            $adm = new \App\Models\Administrasi();
            $adm->kode_administrasi = $kode;
            $adm->pasien_id = $pasien->id;
            $adm->tanggal = $request->tanggal ?? now(); // Pastikan tanggal ada
            $adm->keluhan = strip_tags($request->keluhan);
            $adm->dokter_id = $request->dokter_id;
            $adm->save();
        
            DB::commit();
            dd('Data berhasil disimpan'); // Jika ini muncul, berarti data sukses masuk
        
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error: ' . $e->getMessage()); // Munculkan error jika ada masalah
        
            
        }
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
