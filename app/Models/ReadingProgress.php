<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReadingProgress extends Model
{
    protected $table = 'reading_progress';

    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'manga_id',
        'chapter_page_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function manga(): BelongsTo
    {
        return $this->belongsTo(Manga::class);
    }

    public function chapterPage(): BelongsTo
    {
        return $this->belongsTo(
            ChapterPage::class,
            'chapter_page_id'
        );
    }
}
