<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Komentar;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Artikel::with(['category', 'comments'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate(6);
            
        $categories = Kategori::withCount('articles')->get();
        
        $popularPosts = Artikel::published()
            ->orderBy('view_count', 'desc')
            ->limit(3)
            ->get();

        return view('blog_artikel', compact('articles', 'categories', 'popularPosts'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $article = Artikel::with(['category', 'comments' => function($query) {
            $query->where('is_approved', true)
                  ->orderBy('created_at', 'desc');
        }])->where('slug', $slug)
           ->firstOrFail();

        // Increment view count
        $article->incrementViewCount();

        $relatedArticles = Artikel::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->limit(3)
            ->get();

        return view('single_blog', compact('article', 'relatedArticles'));
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

    public function single_blog()
    {
        return view('single_blog');
    }

    public function storeComment(Request $request, $articleId)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|min:10'
        ]);

        $comment = new Komentar([
            'article_id' => $articleId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'comment' => $validated['comment'],
            'is_approved' => false // Set to true if you don't want moderation
        ]);

        $comment->save();

        return redirect()->back()
            ->with('success', 'Comment submitted successfully and waiting for approval');
    }

    /**
     * Display articles by category.
     */
    public function category($slug)
    {
        $category = Kategori::where('slug', $slug)->firstOrFail();
        
        $articles = Artikel::where('category_id', $category->id)
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate(6);

        return view('blog_artikel', compact('articles', 'category'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $articles = Artikel::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate(6);

        return view('blog_artikel', compact('articles', 'query'));
    }
}
