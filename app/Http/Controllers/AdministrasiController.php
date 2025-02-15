<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pasien;
use App\Models\Dokter;

class AdministrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    if (Auth::user()->role == 'dokter') {
        $data['administrasi'] = \App\Models\Administrasi::with(['pasien', 'dokter'])
            ->where('dokter_id', Auth::user()->dokter->id)
            ->paginate(50);
    } else {
        $data['administrasi'] = \App\Models\Administrasi::with(['pasien', 'dokter'])
            ->orderBy('tanggal', 'desc')
            ->paginate(50);
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
        $data['dokter'] = collect(); 
        return view('administrasi_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //  dd($request->all()); 
        $validasiData = $request->validate([
            'pasien_id' => 'required',
            'dokter_id' => 'required',
            'tanggal' => 'required',
            'keluhan' => 'required',
        ]);

        $dokter = \App\Models\Dokter::findOrfail($request->dokter_id);
        $kodeAdm = \App\Models\Administrasi::orderBy('id', 'desc')->first();
        $kode = 'ADM0001';
        if ($kodeAdm) {
            $kode = 'ADM' . sprintf('%04d', $kodeAdm->id + 1);
        }
        $adm = new \App\Models\Administrasi();
        $adm->kode_administrasi = $kode;
        // $adm->poli_id = $request->poli_id;
        $adm->pasien_id = $request->pasien_id;
        $adm->tanggal = $request->tanggal;
        $adm->keluhan = strip_tags($request->keluhan);
        $adm->dokter_id = $request->dokter_id;
        $adm->biaya = null;
        $adm->save();
        flash('Data sudah disimpan')->success();
        return back();
    }

    public function getPoliByPasien($id)
{
    $pasien = Pasien::find($id);

    if (!$pasien) {
        return response()->json(['error' => 'Pasien tidak ditemukan'], 404);
    }

    $doctor = Dokter::where('id', $pasien->dokter_id)->with('poli')->first();

    if (!$doctor) {
        return response()->json(['error' => 'Dokter tidak ditemukan'], 404);
    }

    return response()->json([
        'doctor' => [
            'id' => $doctor->id,
            'nama_dokter' => $doctor->nama_dokter,
            'nama_poli' => $doctor->poli->nama ?? 'Poli Tidak Ditemukan'
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
        $data['administrasi'] = \App\Models\Administrasi::findOrfail($id);
        $data['list_pasien'] = \App\Models\Pasien::pluck('nama_pasien', 'id');
        $data['list_dokter'] = \App\Models\Dokter::pluck('nama_dokter', 'id');
        return view('administrasi_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasiData = $request->validate([
            'diagnosis' => 'required',
            'biaya'     => 'required|numeric|min:0',
        ]);
        $administrasi = \App\Models\Administrasi::findOrfail($id);
        $administrasi->diagnosis = strip_tags($request->diagnosis);
        $administrasi->biaya = $request->biaya;
        $administrasi->status = 'selesai';
        $administrasi->save();
        flash('Data sudah disimpan')->success();
        return redirect('/administrasi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $administrasi = \App\Models\Administrasi::findOrfail($id);
        $administrasi->delete();
        flash('Data sudah dihapus')->success();
        return back();
    }

    public function printAntrian($id)
{
    $administrasi = \App\Models\Administrasi::with(['pasien', 'dokter.poli'])->findOrFail($id);
    return view('print_antrian', compact('administrasi'));
}
}
