<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Dokter;
use App\Models\JadwalDokter;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cari = request('q');
        if ($cari) {
            $data['pasien'] = \App\Models\Pasien::where('nama_pasien', 'like', '%' . $cari . '%')
                ->orWhere('kode_pasien', 'like', '%' . $cari . '%')
                ->paginate(10);
        } else {
            $data['pasien'] = \App\Models\Pasien::latest()->paginate(10);
        }
        $data['judul'] = 'Data-data Pasien';
        return view('pasien_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['judul'] = 'Tambah Data';
        $data['poli'] = \App\Models\Poli::all(); // Ambil semua poli
        $data['dokter'] = collect();
        $data['jadwals'] = collect();
        return view('pasien_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
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
            'tipe_pemeriksaan' => 'required|in:Klinik,Homecare',// Validasi unik untuk NIK
        ]);
    
        DB::beginTransaction();
    
        try {
            // Membuat kode pasien
            $kodeQuery = \App\Models\Pasien::orderBy('id', 'desc')->first();
            $kode = 'P0001';
            if ($kodeQuery) {
                $kode = 'P' . sprintf('%04d', $kodeQuery->id + 1);
            }
    
            // Membuat nomor antrian per hari
            $tanggalHariIni = now()->toDateString();
            $lastAntrianHariIni = \App\Models\Pasien::whereDate('created_at', $tanggalHariIni)
                ->orderBy('nomor_antrian', 'desc')
                ->first();
    
            $nomorAntrian = 'A001'; // Default nomor antrian
            if ($lastAntrianHariIni) {
                $lastNomor = (int) substr($lastAntrianHariIni->nomor_antrian, 1); // Mengambil angka setelah "A"
                $nomorAntrian = 'A' . sprintf('%03d', $lastNomor + 1). '-' . now()->format('Ymd');
            }
    
            // Menyimpan data pasien
            $pasien = new \App\Models\Pasien();
            $pasien->kode_pasien = $kode;
            $pasien->nomor_antrian = $nomorAntrian;
            $pasien->fill($validasiData);
            $pasien->save();
    
            DB::commit();
    
            // Memberikan notifikasi sukses
            flash('Data berhasil disimpan dengan nomor antrian: ' . $nomorAntrian)->success();
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            // Menangani error
            flash('Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->error();
            return back()->withInput();
        }
    }
    public function getDokterByPoli($poliId)
    {
    $dokters = Dokter::where('poli_id', $poliId)->get();

    if ($dokters->isEmpty()) {
        return response()->json(['message' => 'Tidak ada dokter untuk poli ini'], 404);
    }

    return response()->json(['dokters' => $dokters]);
    }

    public function getJadwalByDokter($dokter_id)
    {
    $jadwals = JadwalDokter::where('dokter_id', $dokter_id)
    ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')") // Urutkan berdasarkan hari
    ->orderBy('jam_mulai', 'asc')
        ->get();

    if ($jadwals->isEmpty()) {
        return response()->json(['message' => 'Tidak ada jadwal untuk dokter ini'], 404);
    }

    return response()->json(['jadwals' => $jadwals]);
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
        $data['pasien'] = \App\Models\Pasien::findOrFail($id);
        $data['dokter'] = \App\Models\Dokter::all();
        $data['judul'] = 'Tambah Data';
        return view('pasien_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasiData = $request->validate([
            'nama_pasien' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'nomor_hp' => 'required',
            'dokter_id' => 'required|exists:dokters,id',
            'alamat' => 'required',
            'nik' => 'required',
        ]);
        $pasien = \App\Models\Pasien::findOrFail($id);
        $pasien->fill($validasiData);
        $pasien->save();

        flash('Data berhasil diubah');
        return redirect('pasien');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pasien = \App\Models\Pasien::findOrFail($id);
        if ($pasien->administrasi->count() >= 1) {
            flash('Data tidak bisa dihapus karena sudah digunakan')->error();
            return back();
        }
        $pasien->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
