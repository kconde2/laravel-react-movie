import React, { useEffect, useRef, useState } from "react";
import { Head, usePage, router } from "@inertiajs/react";
import { PageProps, PaginatedData } from "@/types";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import MovieItem from "@/Components/Movie/MovieItem";

interface TrendingProps extends PageProps {
    trendingMovies: PaginatedData<Domain.Movies.Data.Output.MovieResourceData>;
    timeWindow: string;
}

export default function Trending({ auth }: PageProps) {
    const { trendingMovies, timeWindow } = usePage<TrendingProps>().props;

    const [movies, setMovies] = useState(trendingMovies.data);
    const [page, setPage] = useState(trendingMovies.current_page);
    const [loading, setLoading] = useState(false);
    const [hasMore, setHasMore] = useState(!!trendingMovies.next_page_url);

    const observerTarget = useRef(null);

    useEffect(() => {
        const observer = new IntersectionObserver(
            entries => {
                if (entries[0].isIntersecting && hasMore && !loading) {
                    loadMore();
                }
            },
            { threshold: 1.0 }
        );

        if (observerTarget.current) {
            observer.observe(observerTarget.current);
        }

        return () => {
            if (observerTarget.current) {
                observer.unobserve(observerTarget.current);
            }
        };
    }, [hasMore, loading]);

    const loadMore = () => {
        if (loading || !trendingMovies.next_page_url) return;

        setLoading(true);
        const nextPage = page + 1;

        router.get(
            trendingMovies.next_page_url,
            {},
            {
                preserveState: true,
                preserveScroll: true,
                only: ['trendingMovies'],
                onSuccess: (page) => {
                    // Vérification de type sûre
                    if ('trendingMovies' in page.props && typeof page.props.trendingMovies === 'object') {
                        const newMovies = page.props.trendingMovies as PaginatedData<Domain.Movies.Data.Output.MovieResourceData>;
                        setMovies(prevMovies => [...prevMovies, ...(newMovies.data || [])]);
                        setPage(newMovies.current_page);
                        setHasMore(!!newMovies.next_page_url);
                    }
                    setLoading(false);
                },
                onError: () => {
                    setLoading(false);
                },
            }
        );
    };

    return (
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
                            {movies.length > 0 ? (
                                movies.map((trendingMovie) => (
                                    <MovieItem key={trendingMovie.id} movie={trendingMovie} />
                                ))
                            ) : (
                                <p className="text-gray-500 dark:text-gray-400">No trending movies available.</p>
                            )}
                            {hasMore && (
                                <div ref={observerTarget} className="h-10 flex items-center justify-center">
                                    {loading ? (
                                        <p>Loading more...</p>
                                    ) : (
                                        <p>Scroll for more</p>
                                    )}
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
