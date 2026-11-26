<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Manga;
use App\Models\Library;
use App\Models\Favorite;
use App\Models\Review;
use App\Models\ReadingProgress;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $reader = User::where(
            'email', 'reader@nekomang.test'
        )->firstOrFail();

        $naruto = Manga::where(
            'slug', 'naruto'
        )->firstOrFail();

        $onePiece = Manga::where(
            'slug', 'one-piece'
        )->firstOrFail();

        $soloLeveling = Manga::where(
            'slug', 'solo-leveling'
        )->firstOrFail();

        // 1. Личная библиотека

        Library::updateOrCreate(
            [
                'user_id' => $reader->id,
                'manga_id' => $naruto->id,
            ],
            [
                'status' => 'reading',
            ]
        );

        Library::updateOrCreate(
            [
                'user_id' => $reader->id,
                'manga_id' => $onePiece->id,
            ],
            [
                'status' => 'planned',
            ]
        );

        Library::updateOrCreate(
            [
                'user_id' => $reader->id,
                'manga_id' => $soloLeveling->id,
            ],
            [
                'status' => 'completed',
            ]
        );

        // 2. Избранное

        Favorite::firstOrCreate([
            'user_id' => $reader->id,
            'manga_id' => $naruto->id,
        ]);

        Favorite::firstOrCreate([
            'user_id' => $reader->id,
            'manga_id' => $soloLeveling->id,
        ]);

        // 3. Оценки и отзывы

        Review::updateOrCreate(
            [
                'user_id' => $reader->id,
                'manga_id' => $naruto->id,
            ],
            [
                'rating' => 5,
                'comment' => 'Интересная история и отличные персонажи!',
            ]
        );

        Review::updateOrCreate(
            [
                'user_id' => $reader->id,
                'manga_id' => $soloLeveling->id,
            ],
            [
                'rating' => 5,
                'comment' => 'Очень интересная манхва. Рекомендую!',
            ]
        );

        // 4. Прогресс чтения

        $chapter = $naruto->chapters()
            ->where('number', 2)
            ->firstOrFail();

        $page = $chapter->pages()
            ->where('page_number', 3)
            ->firstOrFail();

        ReadingProgress::updateOrCreate(
            [
                'user_id' => $reader->id,
                'manga_id' => $naruto->id,
            ],
            [
                'chapter_page_id' => $page->id,
            ]
        );
    }
}
