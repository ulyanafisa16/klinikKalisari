<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::withCount('articles')->get();
        return view('kategori_index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:kategoris',
        ]);

        Kategori::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
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
        return view('kategori_edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:kategoris,name,' . $kategori->id,
        ]);

        $kategori->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->articles->count() > 0) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh artikel.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
