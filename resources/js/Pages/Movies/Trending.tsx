import React, { useEffect, useRef, useState, useCallback } from "react";
import { Head, usePage, router } from "@inertiajs/react";
import { PageProps, PaginatedData } from "@/types";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import MovieItem from "@/Components/Movie/MovieItem";

interface TrendingProps extends PageProps {
    trendingMovies: PaginatedData<Domain.Movies.Data.Output.MovieResourceData>;
    timeWindow: string;
    search: string;
}

export default function Trending({ auth }: PageProps) {
    const { trendingMovies, timeWindow, search } = usePage<TrendingProps>().props;

    const [movies, setMovies] = useState(trendingMovies.data);
    const [page, setPage] = useState(trendingMovies.current_page);
    const [loading, setLoading] = useState(false);
    const [hasMore, setHasMore] = useState(!!trendingMovies.next_page_url);
    const [searchTerm, setSearchTerm] = useState(search);

    const observerTarget = useRef<HTMLDivElement | null>(null);

    const loadMore = useCallback(() => {
        if (loading || !trendingMovies.next_page_url) return;

        setLoading(true);

        router.get(
            trendingMovies.next_page_url,
            { search: searchTerm },
            {
                preserveState: true,
                preserveScroll: true,
                only: ['trendingMovies'],
                onSuccess: (page) => {
                    const newMovies = page.props.trendingMovies as PaginatedData<Domain.Movies.Data.Output.MovieResourceData>;
                    setMovies(prevMovies => [...prevMovies, ...newMovies.data]);
                    setPage(newMovies.current_page);
                    setHasMore(!!newMovies.next_page_url);
                    setLoading(false);
                },
                onError: () => setLoading(false),
            }
        );
    }, [loading, trendingMovies.next_page_url, searchTerm]);

    const performSearch = useCallback((value: string) => {
        router.get(
            route('movies.trending', { timeWindow }),
            { search: value },
            {
                preserveState: true,
                preserveScroll: false,
                only: ['trendingMovies', 'search'],
                onSuccess: (page) => {
                    const newMovies = page.props.trendingMovies as PaginatedData<Domain.Movies.Data.Output.MovieResourceData>;
                    setMovies(newMovies.data);
                    setPage(newMovies.current_page);
                    setHasMore(!!newMovies.next_page_url);
                },
                onError: (errors) => console.error('Search error:', errors)
            }
        );
    }, [timeWindow]);

    const handleSearch = useCallback((e: React.ChangeEvent<HTMLInputElement>) => {
        const value = e.target.value;
        setSearchTerm(value);
        const delayDebounceFn = setTimeout(() => {
            performSearch(value);
        }, 300);
        return () => clearTimeout(delayDebounceFn);
    }, [performSearch]);

    useEffect(() => {
        const observer = new IntersectionObserver(
            entries => {
                if (entries[0].isIntersecting) {
                    loadMore();
                }
            },
            { threshold: 1.0 }
        );

        const target = observerTarget.current;
        if (target) observer.observe(target);

        return () => {
            if (target) observer.unobserve(target);
        };
    }, [loadMore]);

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
                    <div className="mb-4">
                        <input
                            type="text"
                            placeholder="Search movies..."
                            className="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value={searchTerm}
                            onChange={handleSearch}
                        />
                    </div>
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-4">
                            {movies.length > 0 ? (
                                movies.map((movie) => (
                                    <MovieItem key={movie.id} movie={movie} />
                                ))
                            ) : (
                                <p className="text-gray-500 dark:text-gray-400">No movies found.</p>
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
