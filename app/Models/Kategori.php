<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['name', 'slug', 'article_count'];

    public function articles()
    {
        return $this->hasMany(Artikel::class, 'kategori_id');
    }
    public function updateArticleCount()
    {
        $this->article_count = $this->articles()->count();
        $this->save();
    }
}
