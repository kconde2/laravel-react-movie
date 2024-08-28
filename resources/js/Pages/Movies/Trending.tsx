import React, { useEffect, useRef, useState } from "react";
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
    const [debouncedSearchTerm, setDebouncedSearchTerm] = useState(search);

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

    useEffect(() => {
        const timer = setTimeout(() => setDebouncedSearchTerm(searchTerm), 300);
        return () => clearTimeout(timer);
    }, [searchTerm]);

    useEffect(() => {
        if (debouncedSearchTerm !== search) {
            performSearch(debouncedSearchTerm);
        }
    }, [debouncedSearchTerm]);

    const loadMore = () => {
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
                    if ('trendingMovies' in page.props && typeof page.props.trendingMovies === 'object') {
                        const newMovies = page.props.trendingMovies as PaginatedData<Domain.Movies.Data.Output.MovieResourceData>;
                        setMovies(prevMovies => [...prevMovies, ...newMovies.data]);
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

    const performSearch = (value: string) => {
        router.get(
            route('movies.trending', { timeWindow }),
            { search: value },
            {
                preserveState: true,
                preserveScroll: false,
                only: ['trendingMovies', 'search'],
                onSuccess: (page) => {
                    if ('trendingMovies' in page.props && typeof page.props.trendingMovies === 'object') {
                        const newMovies = page.props.trendingMovies as PaginatedData<Domain.Movies.Data.Output.MovieResourceData>;
                        setMovies(newMovies.data);
                        setPage(newMovies.current_page);
                        setHasMore(!!newMovies.next_page_url);
                    }
                },
                onError: (errors) => {
                    console.error('Search error:', errors);
                }
            }
        );
    };

    const handleSearch = (e: React.ChangeEvent<HTMLInputElement>) => {
        setSearchTerm(e.target.value);
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
