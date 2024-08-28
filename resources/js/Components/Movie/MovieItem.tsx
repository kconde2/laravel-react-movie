import { Link } from "@inertiajs/react";
import React from "react";

interface MovieItemProps {
    movie: Domain.Movies.Data.Output.MovieResourceData;
    onDelete: (id: number) => void;
}

const MovieItem: React.FC<MovieItemProps> = ({ movie, onDelete }) => {
    const handleDelete = () => {
        if (confirm(`Are you sure you want to delete "${movie.title}"?`)) {
            onDelete(movie.id);
        }
    };

    return (
        <div className="flex items-start p-4 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition duration-150 ease-in-out">
            <Link href={route("movies.detail", movie.id)} className="block flex-shrink-0">
                <img
                    src={movie.posterUrl}
                    alt={movie.title}
                    className="w-32 h-48 object-cover rounded mr-4"
                />
            </Link>
            <div className="flex-grow">
                <h3 className="text-lg font-semibold">{movie.title}</h3>
                <p className="text-sm text-gray-600 dark:text-gray-400 overflow-hidden text-ellipsis">
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
            <button
                onClick={handleDelete}
                className="ml-4 text-red-500 hover:text-red-700"
                aria-label={`Delete ${movie.title}`}
            >
                Delete
            </button>
        </div>
    );
};

export default MovieItem;
