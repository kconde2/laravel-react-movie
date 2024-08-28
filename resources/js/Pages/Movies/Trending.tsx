import { Head, usePage } from "@inertiajs/react";
import { PageProps, PaginatedData } from "@/types";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import MovieItem from "@/Components/Movie/MovieItem";

export default function Trending({ auth }: PageProps) {
    const { trendingMovies, timeWindow } = usePage<{
        trendingMovies: PaginatedData<Domain.Movies.Data.Output.MovieResourceData>;
        timeWindow: string
    }>().props;

    return (
        <>
            <AuthenticatedLayout
                user={auth.user}
                header={
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Trending {timeWindow}
                    </h2>
                }
            >
                <Head title="Trending" />

                <div className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div className="p-4">
                                {trendingMovies.data.length > 0 ? (
                                    trendingMovies.data.map((trendingMovie) => (
                                        <MovieItem key={trendingMovie.id} movie={trendingMovie} />
                                    ))
                                ) : (
                                    <p className="text-gray-500 dark:text-gray-400">No trending movies available.</p>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
}
