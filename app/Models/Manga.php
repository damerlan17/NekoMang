<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Manga extends Model
{
    protected $table = 'manga';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover',
        'author',
        'artist',
        'type',
        'release_year',
        'status',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'release_year' => 'integer',
            'views' => 'integer',
        ];
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(
            Genre::class,
            'genre_manga',
            'manga_id',
            'genre_id'
        );
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)
            ->orderBy('number');
    }

    public function libraries(): HasMany
    {
        return $this->hasMany(Library::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function readingProgress(): HasMany
    {
        return $this->hasMany(ReadingProgress::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating(): float
    {
        return round(
            (float) $this->reviews()->avg('rating'),
            1
        );
    }
}
