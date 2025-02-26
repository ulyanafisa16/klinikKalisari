<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Artikel::query();
        
        // Apply search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }
        
        // Apply status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Get data with pagination
        $articles = $query->with('category')
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);
        
        // Get all categories for the filter dropdown
        $categories = Kategori::all();
        
        return view('artikel_index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Kategori::all();
        return view('artikel_create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all()); 
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:artikels',
            'content' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ringkasan' => 'nullable|max:500',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }
        
        // Set published_at date
        if ($validated['status'] == 'published') {
            $validated['published_at'] = $validated['published_at'] ?? now();
        } else {
            $validated['published_at'] = null;
        }
        
        // Generate excerpt if not provided
        if (empty($validated['ringkasan'])) {
            $validated['ringkasan'] = Str::limit(strip_tags($validated['content']), 200);
        }
        $article = Artikel::create($validated);
        
        // Override status based on action button
        if ($request->action == 'publish') {
            $article->status = 'published';
            $article->published_at = $article->published_at ?? now();
            $article->save();
        } elseif ($request->action == 'draft') {
            $article->status = 'draft';
            $article->published_at = null;
            $article->save();
        }
        
        return redirect()->route('artikel.index')
                        ->with('success', 'Artikel berhasil dibuat.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Artikel::findOrFail($id);
        return redirect()->route('blog.show', $article->slug);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Artikel::findOrFail($id);
        $categories = Kategori::all();
        
        return view('artikel_edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Artikel::findOrFail($id);
        
        // Validate input
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:artikels,slug,' . $id,
            'content' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ringkasan' => 'nullable|max:500',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Handle the thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($article->thumbnail) {
                Storage::delete($article->thumbnail);
            }
            
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }
        if ($validated['status'] == 'published' && !$article->published_at) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        } elseif ($validated['status'] == 'draft') {
            $validated['published_at'] = null;
        }
        
        // Generate excerpt if not provided
        if (empty($validated['ringkasan'])) {
            $validated['ringkasan'] = Str::limit(strip_tags($validated['content']), 200);
        }
        $article->update($validated);
        
        // Override status based on action button
        if ($request->action == 'publish') {
            $article->status = 'published';
            $article->published_at = $article->published_at ?? now();
            $article->save();
        } elseif ($request->action == 'draft') {
            $article->status = 'draft';
            $article->published_at = null;
            $article->save();
        }
        
        return redirect()->route('artikel.index')
                        ->with('success', 'Artikel berhasil diperbarui.');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Artikel::findOrFail($id);
        
        // Delete thumbnail if exists
        if ($article->thumbnail) {
            Storage::delete($article->thumbnail);
        }
        
        $article->delete();
        
        return redirect()->route('artikel.index')
                        ->with('success', 'Artikel berhasil dihapus.');
    
    }
}
