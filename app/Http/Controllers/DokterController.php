<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Dokter;
use App\Models\User;


class DokterController extends Controller
{
    public function index()
    {
        $data['dokter'] = Dokter::with('poli')->latest()->get();
        $data['judul'] = 'Data Dokter';
        return view('dokter_index', $data);
    }

    public function create()
    {
        $data['list_poli'] =  \App\Models\Poli::get(); // Ambil daftar poli
        return view('dokter_create', $data);
    }

    public function store(Request $request)
    {
        $validasiData = $request->validate([
            'nama_dokter' => 'required',
            'kampus' => 'required',
            'poli_id' => 'required|exists:polis,id',
            'password' => 'required',
            'nomor_hp' => 'required|numeric|unique:dokters,nomor_hp',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:8048',
            'twitter' => 'required',
            'facebook' => 'required',
            'instagram' => 'required',
            'tiktok' => 'required'
        ]);

        $kodeQuery = Dokter::orderBy('id', 'desc')->first();
        $kode = 'D0001';
        if ($kodeQuery) {
            $kode = 'D' . sprintf('%04d', $kodeQuery->id + 1);
        }

        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $validasiData['nama_dokter'];
            $user->email = $validasiData['nomor_hp'] . '@dokter.com';
            $user->password = bcrypt($request->password);
            $user->role = 'dokter';
            $user->save();

            $dokter = new Dokter();
            if ($request->hasFile('foto')) {
                unset($validasiData['foto']);
                $path = $request->file('foto')->store('foto_dokter', 'public');
                $dokter->foto = $path;
            }

            $dokter->user_id = $user->id;
            $dokter->kode_dokter = $kode;
            $dokter->nama_dokter = $request->nama_dokter;
            $dokter->kampus = $request->kampus;
            $dokter->poli_id = $request->poli_id;
            $dokter->nomor_hp = $request->nomor_hp;
            $dokter->twitter = $request->twitter;
            $dokter->facebook = $request->facebook;
            $dokter->instagram = $request->instagram;
            $dokter->tiktok = $request->tiktok;
            $dokter->save();

            DB::commit();
            flash('Data berhasil disimpan');
            return back();
        } catch (\Throwable $e) {
            DB::rollback();
            flash('Ops... Terjadi kesalahan, ' . $e->getMessage())->error();
            return back();
        }
    }

    public function show(string $id)
    {
        $data['dokter'] = Dokter::with('poli')->findOrFail($id);
        return view('dokter_show', $data);
    }

    public function edit(string $id)
    {
        $data['dokter'] = Dokter::findOrFail($id);
        $data['list_poli'] =  \App\Models\Poli::get();// Ubah ke daftar poli
        return view('dokter_edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $validasiData = $request->validate([
            'nama_dokter' => 'required',
            'kampus' => 'required',
            'poli_id' => 'required|exists:polis,id',
            'nomor_hp' => 'required',
            'twitter' => 'required',
            'facebook' => 'required',
            'instagram' => 'required',
            'tiktok' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:8048'
        ]);

        $dokter = Dokter::findOrFail($id);
        if ($request->hasFile('foto')) {
            unset($validasiData['foto']);
            $path = $request->file('foto')->store('foto_dokter', 'public');
            $dokter->foto = $path;
        }

        $dokter->fill($validasiData);
        $dokter->save();

        flash('Data berhasil diubah');
        return redirect('/dokter');
    }

    public function destroy(string $id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->delete();
        flash('Data berhasil dihapus');
        return back();
    }

    public function publicIndex()
{
    $dokter = Dokter::with('poli')->get();
    return view('frontend.doctors', compact('dokter'));
}
}
