import { Head, usePage, Link } from "@inertiajs/react";
import { PageProps } from "@/types";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

export default function Show({ auth }: PageProps) {
    const { movie } = usePage<{
        movie: Domain.Movies.Data.Output.MovieResourceData;
    }>().props;

    return (
        <>
            <AuthenticatedLayout
                user={auth.user}
                header={
                    <div className="flex justify-between items-center">
                        <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Movie Detail - {movie.title}
                        </h2>
                        <Link
                            href={route('movies.edit', movie.id)}
                            className="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Edit
                        </Link>
                    </div>
                }
            >
                <Head title={`${movie.title} - Movie Details`} />
                <div className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <div className="flex flex-col md:flex-row">
                                <div className="md:w-1/3">
                                    <img
                                        src={movie.posterUrl}
                                        alt={movie.title}
                                        className="w-full h-auto object-cover rounded-lg shadow-lg"
                                    />
                                </div>
                                <div className="md:w-2/3 md:pl-6 mt-4 md:mt-0">
                                    <h1 className="text-3xl font-bold mb-2">
                                        {movie.title}
                                    </h1>
                                    <p className="text-gray-600 mb-4">
                                        {movie.originalTitle}
                                    </p>
                                    <p className="text-gray-800 mb-4">
                                        {movie.overview}
                                    </p>
                                    <div className="grid grid-cols-2 gap-4">
                                        <div>
                                            <p>
                                                <strong>Release Date:</strong>{" "}
                                                {movie.releaseDate}
                                            </p>
                                            <p>
                                                <strong>Language:</strong>{" "}
                                                {movie.originalLanguage}
                                            </p>
                                            <p>
                                                <strong>Popularity:</strong>{" "}
                                                {movie.popularity.toFixed(2)}
                                            </p>
                                            <p>
                                                <strong>Media Type:</strong>{" "}
                                                {movie.mediaType}
                                            </p>
                                        </div>
                                        <div>
                                            <p>
                                                <strong>Vote Average:</strong>{" "}
                                                {movie.voteAverage.toFixed(1)}
                                                /10
                                            </p>
                                            <p>
                                                <strong>Vote Count:</strong>{" "}
                                                {movie.voteCount}
                                            </p>
                                            <p>
                                                <strong>Adult Content:</strong>{" "}
                                                {movie.isAdult ? "Yes" : "No"}
                                            </p>
                                            <p>
                                                <strong>Video:</strong>{" "}
                                                {movie.isVideo ? "Yes" : "No"}
                                            </p>
                                        </div>
                                    </div>
                                    <div className="mt-4">
                                        <p>
                                            <strong>TMDB ID:</strong>{" "}
                                            {movie.tmdbId}
                                        </p>
                                        <p>
                                            <strong>Time Window:</strong>{" "}
                                            {movie.timeWindow}
                                        </p>
                                        <p>
                                            <strong>Created At:</strong>{" "}
                                            {new Date(
                                                movie.createdAt
                                            ).toLocaleString()}
                                        </p>
                                        <p>
                                            <strong>Updated At:</strong>{" "}
                                            {new Date(
                                                movie.updatedAt
                                            ).toLocaleString()}
                                        </p>
                                    </div>
                                    <div className="mt-6">
                                        <Link
                                            href={route('movies.edit', movie.id)}
                                            className="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        >
                                            Edit Movie
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
}
