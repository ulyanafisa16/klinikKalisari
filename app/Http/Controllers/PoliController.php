<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poli;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['poli'] = \App\Models\Poli::latest()->get();
        $data['judul'] = 'Data-data Poli';
        return view('poli_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['poli'] = new \App\Models\Poli();
        $data['judul'] = 'Tambah Data';
        return view('poli_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasiData = $request->validate([
            'nama' => 'required|unique:polis',
            'deskripsi' => 'required'
        ]);
        $poli = new \App\Models\Poli();
        $poli->fill($validasiData);
        $poli->save();

        flash('Data berhasil disimpan');
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
        $data['poli'] = \App\Models\Poli::findOrFail($id);
        $data['judul'] = 'Ubah Data';
        return view('poli_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasiData = $request->validate([
            'nama' => 'required|unique:polis,nama,' . $id . ',id',
            'deskripsi' => 'required'
        ]);
        $dokter = \App\Models\Poli::findOrFail($id);
        $dokter->fill($validasiData);
        $dokter->save();

        flash('Data berhasil diubah');
        return redirect('poli');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokter = \App\Models\Poli::findOrFail($id);
        $dokter->delete();
        flash('Data berhasil dihapus');
        return back();
    }

    public function publicIndex()
{
    $poli = Poli::all();
    $icons = [
        'Poli Umum' => 'fa-stethoscope',
        'Poli Gigi' => 'fa-tooth',
        'Poli Anak' => 'fa-baby',
        'Poli Mata' => 'fa-eye',
        'Poli THT' => 'fa-ear-deaf',
        'Poli Jantung' => 'fa-heartbeat',
        'Poli Kandungan' => 'fa-person-pregnant',
        'Poli Syaraf' => 'fa-brain',
        'Poli Orthopedi' => 'fa-bone',
        'Poli Kulit' => 'fa-allergies'
    ];
    
    return view('medilab.services', compact('poli', 'icons'));
}
}
