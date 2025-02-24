<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'excerpt',
        'category_id',
        'published_at',
        'status'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function comments()
    {
        return $this->hasMany(Komentar::class);
    }
    public function scopePublished($query)
{
    return $query->where('status', 'published')
                 ->where('published_at', '<=', now());
}

public function getReadTimeAttribute()
{
    $words = str_word_count(strip_tags($this->content));
    $minutes = ceil($words / 200);
    return $minutes;
}

public function incrementViewCount()
{
    $this->increment('view_count');
}
}
