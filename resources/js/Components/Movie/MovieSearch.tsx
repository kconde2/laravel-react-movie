import React, { useEffect, useState } from "react";

interface MovieSearchProps {
    searchTerm: string;
    onSearch: (value: string) => void;
}

const MovieSearch: React.FC<MovieSearchProps> = ({ searchTerm, onSearch }) => {
    const [localSearchTerm, setLocalSearchTerm] = useState(searchTerm);

    useEffect(() => {
        const delayDebounceFn = setTimeout(() => {
            if (localSearchTerm !== searchTerm) {
                onSearch(localSearchTerm);
            }
        }, 300);

        return () => clearTimeout(delayDebounceFn);
    }, [localSearchTerm, searchTerm, onSearch]);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setLocalSearchTerm(e.target.value);
    };

    return (
        <div className="mb-4">
            <input
                type="text"
                placeholder="Search movies..."
                className="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                value={localSearchTerm}
                onChange={handleChange}
            />
        </div>
    );
};

export default MovieSearch;
