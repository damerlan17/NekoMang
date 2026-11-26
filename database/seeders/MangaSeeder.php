<?php

namespace Database\Seeders;

use App\Models\Manga;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class MangaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Наруто',
                'slug' => 'naruto',
                'description' => 'История молодого ниндзя, мечтающего стать Хокаге и заслужить признание окружающих.',
                'author' => 'Масаси Кисимото',
                'artist' => 'Масаси Кисимото',
                'type' => 'manga',
                'release_year' => 1999,
                'status' => 'completed',
                'genres' => [
                    'action', 'adventure', 'fantasy',
                ],
            ],
            [
                'title' => 'Ван-Пис',
                'slug' => 'one-piece',
                'description' => 'Приключения Монки Д. Луффи и его команды в поисках легендарного сокровища.',
                'author' => 'Эйитиро Ода',
                'artist' => 'Эйитиро Ода',
                'type' => 'manga',
                'release_year' => 1997,
                'status' => 'ongoing',
                'genres' => [
                    'action', 'adventure', 'comedy',
                ],
            ],
            [
                'title' => 'Атака титанов',
                'slug' => 'attack-on-titan',
                'description' => 'Человечество пытается выжить в мире, населённом загадочными гигантами.',
                'author' => 'Хадзимэ Исаяма',
                'artist' => 'Хадзимэ Исаяма',
                'type' => 'manga',
                'release_year' => 2009,
                'status' => 'completed',
                'genres' => [
                    'action', 'drama', 'horror',
                ],
            ],
            [
                'title' => 'Поднятие уровня в одиночку',
                'slug' => 'solo-leveling',
                'description' => 'Слабый охотник получает необычную способность становиться сильнее.',
                'author' => 'Чхугон',
                'artist' => 'DUBU',
                'type' => 'manhwa',
                'release_year' => 2018,
                'status' => 'completed',
                'genres' => [
                    'action', 'adventure', 'fantasy',
                ],
            ],
            [
                'title' => 'Тетрадь смерти',
                'slug' => 'death-note',
                'description' => 'Школьник находит загадочную тетрадь, обладающую сверхъестественной силой.',
                'author' => 'Цугуми Оба',
                'artist' => 'Такэси Обата',
                'type' => 'manga',
                'release_year' => 2003,
                'status' => 'completed',
                'genres' => [
                    'psychology', 'mystery', 'detective',
                ],
            ],
            [
                'title' => 'Клинок, рассекающий демонов',
                'slug' => 'demon-slayer',
                'description' => 'Юноша отправляется в опасное путешествие, чтобы спасти свою сестру.',
                'author' => 'Коёхару Готогэ',
                'artist' => 'Коёхару Готогэ',
                'type' => 'manga',
                'release_year' => 2016,
                'status' => 'completed',
                'genres' => [
                    'action', 'fantasy', 'drama',
                ],
            ],
        ];

        foreach ($items as $item) {
            $genreSlugs = $item['genres'];

            unset($item['genres']);

            $manga = Manga::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );

            $genreIds = Genre::whereIn(
                'slug',
                $genreSlugs
            )->pluck('id');

            $manga->genres()->sync($genreIds);
        }
    }
}
