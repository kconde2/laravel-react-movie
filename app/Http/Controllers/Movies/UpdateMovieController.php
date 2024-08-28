<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateMovieController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'overview' => 'nullable|string',
        ]);

        $movie->update($validated);

        return redirect()
            ->route('movies.detail', $movie->id)
            ->with('success', 'Movie updated successfully.');
    }
}
