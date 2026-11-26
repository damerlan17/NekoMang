<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'action' => 'Экшен',
            'adventure' => 'Приключения',
            'romance' => 'Романтика',
            'fantasy' => 'Фэнтези',
            'comedy' => 'Комедия',
            'drama' => 'Драма',
            'horror' => 'Ужасы',
            'psychology' => 'Психология',
            'slice-of-life' => 'Повседневность',
            'mystery' => 'Мистика',
            'isekai' => 'Исекай',
            'sports' => 'Спорт',
            'detective' => 'Детектив',
            'sci-fi' => 'Фантастика',
            'historical' => 'История',
        ];

        foreach ($genres as $slug => $name) {
            Genre::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }
    }
}
