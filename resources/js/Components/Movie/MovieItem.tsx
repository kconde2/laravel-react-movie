import React from "react";

interface MovieItemProps {
    movie: Domain.Movies.Data.Output.MovieResourceData;
}

const MovieItem: React.FC<MovieItemProps> = ({ movie }) => {
    return (
        <div className="flex items-start p-4 border-b border-gray-200 dark:border-gray-700">
            <img
                src={movie.posterUrl}
                alt={movie.title}
                className="w-32 h-auto rounded mr-4"
            />
            <div className="flex-grow">
                <h3 className="text-lg font-semibold">{movie.title}</h3>
                <p className="text-sm text-gray-600 dark:text-gray-400">
                    {movie.overview}
                </p>
                <div className="mt-2">
                    <span className="text-sm text-gray-500 dark:text-gray-400">
                        Release Date: {movie.releaseDate}
                    </span>
                    <span className="ml-4 text-sm text-gray-500 dark:text-gray-400">
                        Rating: {movie.voteAverage}
                    </span>
                    <span className="ml-4 text-sm text-gray-500 dark:text-gray-400">
                        Language: {movie.originalLanguage}
                    </span>
                    <span className="ml-4 text-sm text-gray-500 dark:text-gray-400">
                        Media Type: {movie.mediaType}
                    </span>
                    <span className="ml-4 text-sm text-gray-500 dark:text-gray-400">
                        Popularity: {movie.popularity.toFixed(2)}
                    </span>
                    <span className="ml-4 text-sm text-gray-500 dark:text-gray-400">
                        Votes: {movie.voteCount}
                    </span>
                    <span className="ml-4 text-sm text-gray-500 dark:text-gray-400">
                        Time Window: {movie.timeWindow}
                    </span>
                </div>
            </div>
        </div>
    );
};

export default MovieItem;
