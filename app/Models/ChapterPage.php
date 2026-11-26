<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChapterPage extends Model
{
    protected $table = 'chapter_pages';

    public $timestamps = false;

    protected $fillable = [
        'chapter_id',
        'page_number',
        'image_path',
    ];

    protected function casts(): array
    {
        return [
            'page_number' => 'integer',
        ];
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function readingProgress(): HasMany
    {
        return $this->hasMany(
            ReadingProgress::class,
            'chapter_page_id'
        );
    }
}
