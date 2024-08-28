import React, { useEffect, useState, useCallback } from "react";
import { Head, usePage, router } from "@inertiajs/react";
import { PageProps, PaginatedData } from "@/types";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import MovieList from "@/Components/Movie/MovieList";
import MovieSearch from "@/Components/Movie/MovieSearch";
import MovieListLoadMore from "@/Components/Movie/MovieListLoadMore";

interface TrendingProps extends PageProps {
    trendingMovies: PaginatedData<Domain.Movies.Data.Output.MovieResourceData>;
    timeWindow: string;
    search: string;
}

export default function Trending({ auth }: PageProps) {
    const { trendingMovies, timeWindow, search } = usePage<TrendingProps>().props;

    const [searchTerm, setSearchTerm] = useState(search ?? "");

    const [movies, setMovies] = useState(trendingMovies.data);
    const [page, setPage] = useState(trendingMovies.current_page);
    const [loading, setLoading] = useState(false);
    const [hasMore, setHasMore] = useState(!!trendingMovies.next_page_url);

    const loadMore = useCallback(() => {
        if (loading || !trendingMovies.next_page_url) return;

        setLoading(true);

        router.get(
            trendingMovies.next_page_url,
            { search: searchTerm },
            {
                preserveState: true,
                preserveScroll: true,
                only: ["trendingMovies"],
                onSuccess: (page) => {
                    const newMovies = page.props
                        .trendingMovies as PaginatedData<Domain.Movies.Data.Output.MovieResourceData>;
                    setMovies((prevMovies) => [
                        ...prevMovies,
                        ...newMovies.data,
                    ]);
                    setPage(newMovies.current_page);
                    setHasMore(!!newMovies.next_page_url);
                    setLoading(false);
                },
                onError: () => setLoading(false),
            }
        );
    }, [loading, trendingMovies.next_page_url, searchTerm]);

    const performSearch = useCallback(
        (value: string) => {
            setSearchTerm(value);
            router.get(
                route("movies.trending", { timeWindow }),
                { search: value },
                {
                    preserveState: true,
                    preserveScroll: false,
                    only: ["trendingMovies", "search"],
                    onSuccess: (page) => {
                        const newMovies = page.props
                            .trendingMovies as PaginatedData<Domain.Movies.Data.Output.MovieResourceData>;
                        setMovies(newMovies.data);
                        setPage(newMovies.current_page);
                        setHasMore(!!newMovies.next_page_url);
                    },
                    onError: (errors) => console.error("Search error:", errors),
                }
            );
        },
        [timeWindow]
    );

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
                    <MovieSearch searchTerm={searchTerm} onSearch={performSearch} />
                    <MovieList movies={movies} />
                    <MovieListLoadMore
                        hasMore={hasMore}
                        loading={loading}
                        loadMore={loadMore}
                    />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
