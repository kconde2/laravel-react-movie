<?php

namespace Domain\Movies\Commands;

use Domain\Movies\Actions\AddMovieAction;
use Domain\Movies\Actions\UpdateMovieAction;
use Domain\Movies\Data\MovieData;
use Domain\Movies\Enums\MovieTimeWindow;
use Domain\Movies\Interfaces\MovieApiDataProviderInterface;
use Domain\Movies\Models\Movie;
use Illuminate\Console\Command;

class FetchMoviesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movies:fetch
                            {timeWindow=day : time window to fetch (day or week)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch trending movies and store them in the database';

    public function __construct(
        private MovieApiDataProviderInterface $movieApiDataProvider,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timeWindow = MovieTimeWindow::tryFrom($this->argument('timeWindow')) ?? MovieTimeWindow::DAY;

        $this->info("Fetching trending movies for the {$timeWindow->value} time window...");

        $this->fetchMoviesForPage($timeWindow);

        $this->info('Trending movies have been fetched and stored successfully.');
    }

    /**
     * Fetch and process movies for a specific page.
     */
    private function fetchMoviesForPage(MovieTimeWindow $timeWindow)
    {
        $trendingMovies = $this->movieApiDataProvider->getTrendingMovies($timeWindow->value);

        $this->info("Processing {$timeWindow->value} time window...");

        foreach ($trendingMovies as $trendingMovie) {
            try {
                $movieData = MovieData::from([...$trendingMovie, 'timeWindow' => $timeWindow->value]);

                $existingMovie = Movie::where('tmdb_id', $movieData->tmdbId)->first();

                if ($existingMovie) {
                    UpdateMovieAction::run($existingMovie, $movieData);
                } else {
                    AddMovieAction::run($movieData);
                }
            } catch (\Exception $e) {
                $this->error('Error processing movie ID: '.$e->getMessage());

                continue;
            }
        }
    }
}
