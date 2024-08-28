<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditMovieController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia('Movies/Edit', [
            'movie' => $movie,
        ]);
    }
}
