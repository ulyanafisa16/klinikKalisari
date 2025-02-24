<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $fillable = [
        'article_id',
        'name',
        'email',
        'comment',
        'is_approved'
    ];

    public function article()
    {
        return $this->belongsTo(Artikel::class);
    }
}
