<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Manga;
use App\Models\Genre;
use App\Models\Chapter;
use App\Models\Review;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [

            'usersCount' => User::count(),

            'mangaCount' => Manga::count(),

            'genresCount' => Genre::count(),

            'chaptersCount' => Chapter::count(),

            'reviewsCount' => Review::count(),

        ]);
    }
}
