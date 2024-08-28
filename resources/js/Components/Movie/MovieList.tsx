import React from "react";
import MovieItem from "@/Components/Movie/MovieItem";

interface MovieListProps {
    movies: Domain.Movies.Data.Output.MovieResourceData[];
}

const MovieList: React.FC<MovieListProps> = ({ movies }) => {
    return (
        <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-4">
                {movies.length > 0 ? (
                    movies.map((movie) => (
                        <MovieItem key={movie.id} movie={movie} />
                    ))
                ) : (
                    <p className="text-gray-500 dark:text-gray-400">No movies found.</p>
                )}
            </div>
        </div>
    );
};

export default MovieList;
