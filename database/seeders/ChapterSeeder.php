<?php

namespace Database\Seeders;

use App\Models\Manga;
use App\Models\Chapter;
use App\Models\ChapterPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ChapterSeeder extends Seeder
{
    public function run(): void
    {
        $slugs = [
            'naruto',
            'one-piece',
            'attack-on-titan',
            'solo-leveling',
            'death-note',
            'demon-slayer',
        ];

        $mangaList = Manga::whereIn(
            'slug', $slugs
        )->get();

        foreach ($mangaList as $manga) {
            for ($number = 1; $number <= 3; $number++) {

                $chapter = Chapter::updateOrCreate(
                    [
                        'manga_id' => $manga->id,
                        'number' => $number,
                    ],
                    [
                        'title' => 'Глава ' . $number,
                    ]
                );

                for ($page = 1; $page <= 5; $page++) {

                    $path = "demo/{$manga->slug}/"
                        . "{$number}/{$page}.svg";

                    $svg = <<<SVG
                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="800" height="1100"
                         viewBox="0 0 800 1100">
                        <rect width="800" height="1100"
                              fill="#f5f5f5"/>
                        <rect x="30" y="30"
                              width="740" height="1040"
                              fill="none" stroke="#1A1A2E"
                              stroke-width="4"/>
                        <g font-family="Arial"
                           text-anchor="middle">
                            <text x="400" y="400"
                                  font-size="52"
                                  fill="#FF6B6B">NekoMang</text>
                            <text x="400" y="500"
                                  font-size="32"
                                  fill="#1A1A2E">Chapter {$number}</text>
                            <text x="400" y="570"
                                  font-size="28"
                                  fill="#1A1A2E">Page {$page}</text>
                            <text x="400" y="680"
                                  font-size="22"
                                  fill="#777777">Demo page</text>
                        </g>
                    </svg>
                    SVG;

                    if (!Storage::disk('public')->put($path, $svg)) {
                        throw new \RuntimeException(
                            'Не удалось сохранить файл: ' . $path
                        );
                    }

                    ChapterPage::updateOrCreate(
                        [
                            'chapter_id' => $chapter->id,
                            'page_number' => $page,
                        ],
                        [
                            'image_path' => $path,
                        ]
                    );
                }
            }
        }
    }
}
