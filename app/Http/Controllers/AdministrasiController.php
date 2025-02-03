<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pasien;

class AdministrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    if (Auth::user()->role == 'dokter') {
        $data['administrasi'] = \App\Models\Administrasi::where('dokter_id', Auth::user()->dokter->id)
            ->paginate(50);
    } else {
        $data['administrasi'] = \App\Models\Administrasi::orderBy('tanggal', 'desc')->paginate(50);
    }

    $data['judul'] = 'Data Administrasi';
    return view('administrasi_index', $data);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['list_pasien'] = \App\Models\Pasien::get();
        $data['list_poli'] = collect(); 
        return view('administrasi_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasiData = $request->validate([
            'pasien_id' => 'required',
            'poli_id' => 'required',
            'tanggal' => 'required',
            'keluhan' => 'required',
            // 'nik'     => 'required',
        ]);

    //     $pasien = \App\Models\Pasien::find($request->pasien_id) 
    //       ?? \App\Models\Pasien::where('nik', $request->nik)->first();
    //     if (!$pasien) {
    //     $pasien = new \App\Models\Pasien();
    //     $pasien->nik = $request->nik;
    // // Tambahkan data lain yang relevan, seperti nama, alamat, dll.
    //     $pasien->save();
    //     }

        $poli = \App\Models\Poli::findOrfail($request->poli_id);
        $kodeAdm = \App\Models\Administrasi::orderBy('id', 'desc')->first();
        $kode = 'ADM0001';
        if ($kodeAdm) {
            $kode = 'ADM' . sprintf('%04d', $kodeAdm->id + 1);
        }
        $adm = new \App\Models\Administrasi();
        $adm->kode_administrasi = $kode;
        $adm->poli_id = $request->poli_id;
        $adm->pasien_id = $request->pasien_id;
        $adm->tanggal = $request->tanggal;
        $adm->keluhan = strip_tags($request->keluhan);
        $adm->dokter_id = $request->dokter_id;
        $adm->biaya = $poli->biaya;
        $adm->save();
        flash('Data sudah disimpan')->success();
        return back();
    }

    public function getPoliByPasien($id)
    {
        $pasien = \App\Models\Pasien::with(['poli', 'dokter'])->find($id);
    return response()->json([
        'poli' => [
            'id' => $pasien->poli->id,
            'nama' => $pasien->poli->nama
        ],
        'dokter' => [
            'id' => $pasien->dokter->id ?? null,
            'nama' => $pasien->dokter->nama ?? null
        ]
    ]);
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
