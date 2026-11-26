<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    protected $table = 'genres';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function manga(): BelongsToMany
    {
        return $this->belongsToMany(
            Manga::class,
            'genre_manga',
            'genre_id',
            'manga_id'
        );
    }
}
