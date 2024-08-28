import React, { useEffect, useRef } from "react";

interface MovieListLoadMoreProps {
    hasMore: boolean;
    loading: boolean;
    loadMore: () => void;
}

const MovieListLoadMore: React.FC<MovieListLoadMoreProps> = ({ hasMore, loading, loadMore }) => {
    const observerTarget = useRef<HTMLDivElement | null>(null);

    useEffect(() => {
        if (!hasMore) return;

        const observer = new IntersectionObserver(
            (entries) => {
                if (entries[0].isIntersecting && hasMore && !loading) {
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
    }, [hasMore, loading, loadMore]);

    return (
        <div ref={observerTarget} className="h-10 flex items-center justify-center">
            {loading ? (
                <p>Loading more...</p>
            ) : (
                hasMore ? <p>Scroll for more</p> : <p>No more movies to load.</p>
            )}
        </div>
    );
};

export default MovieListLoadMore;
