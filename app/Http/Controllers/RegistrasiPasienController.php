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
    try {
        $validasiData = $request->validate([
            'nama_pasien' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'nomor_hp' => 'required',
            'dokter_id' => 'required|exists:dokters,id',
            'alamat' => 'required',
            'nik' => 'required|digits:16|unique:pasiens,nik',
            'poli_id' => 'required|exists:polis,id',
            'jadwal_id' => 'required|exists:jadwal_dokters,id',
            'jam_kunjungan' => 'required',
            'tipe_pemeriksaan' => 'required|in:Klinik,Homecare',
        ]);

        DB::beginTransaction();
        
        // Generate kode pasien
        $kodeQuery = \App\Models\Pasien::orderBy('id', 'desc')->first();
        $kode = 'P0001';
        if ($kodeQuery) {
            $kode = 'P' . sprintf('%04d', $kodeQuery->id + 1);
        }

        // Generate nomor antrian
        $tanggalHariIni = now()->toDateString();
        $lastAntrianHariIni = \App\Models\Pasien::whereDate('created_at', $tanggalHariIni)
            ->orderBy('nomor_antrian', 'desc')
            ->first();

        $nomorAntrian = 'A001-' . now()->format('Ymd'); // Format default: A001-20250214
        if ($lastAntrianHariIni && $lastAntrianHariIni->nomor_antrian) {
            $lastNomor = (int) substr($lastAntrianHariIni->nomor_antrian, 1, 3); // Mengambil 3 digit setelah "A"
            $nomorAntrian = 'A' . sprintf('%03d', $lastNomor + 1) . '-' . now()->format('Ymd');
        }
    
        // Simpan data pasien
        $pasien = new \App\Models\Pasien();
        $pasien->kode_pasien = $kode;
        $pasien->nomor_antrian = $nomorAntrian;  // Tambahkan nomor antrian
        $pasien->nama_pasien = $request->nama_pasien;
        $pasien->jenis_kelamin = $request->jenis_kelamin;
        $pasien->tanggal_lahir = $request->tanggal_lahir;
        $pasien->alamat = $request->alamat;
        $pasien->tipe_pemeriksaan = $request->tipe_pemeriksaan;
        $pasien->jam_kunjungan = $request->jam_kunjungan;
        $pasien->jadwal_id = $request->jadwal_id;
        $pasien->nik = $request->nik;
        $pasien->poli_id = $request->poli_id;
        $pasien->dokter_id = $request->dokter_id;
        $pasien->nomor_hp = $request->nomor_hp;
        $pasien->save();
    
        // Generate kode administrasi
        $kodeAdm = \App\Models\Administrasi::orderBy('id', 'desc')->first();
        $kodeAdministrasi = 'ADM0001';
        if ($kodeAdm) {
            $kodeAdministrasi = 'ADM' . sprintf('%04d', $kodeAdm->id + 1);
        }
    
        // Simpan data administrasi
        $adm = new \App\Models\Administrasi();
        $adm->kode_administrasi = $kodeAdministrasi;
        $adm->pasien_id = $pasien->id;
        $adm->keluhan = strip_tags($request->keluhan);
        $adm->tanggal = now();
        $adm->dokter_id = $request->dokter_id;
        $adm->save();
    
        DB::commit();
        
        flash('Pendaftaran berhasil')->success();
        return redirect()->route('registrasipasien.create');
        
    } catch (\Exception $e) {
        DB::rollBack();
        flash('Terjadi kesalahan: ' . $e->getMessage())->error();
        return back()->withInput();
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
