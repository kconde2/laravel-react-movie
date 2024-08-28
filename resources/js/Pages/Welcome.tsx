import { Link, Head } from '@inertiajs/react';
import { PageProps } from '@/types';

export default function Welcome({ auth, laravelVersion, phpVersion }: PageProps<{ laravelVersion: string, phpVersion: string }>) {
    return (
        <>
            <Head title="Welcome to MovieApp" />
            <div className="bg-gray-900 text-white min-h-screen flex flex-col items-center justify-center">
                <div className="w-full max-w-5xl px-6">
                    <header className="flex justify-center items-center py-8">
                        <nav className="space-x-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="text-sm font-medium text-gray-300 hover:text-white transition"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="text-sm font-medium text-gray-300 hover:text-white transition"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="text-sm font-medium text-gray-300 hover:text-white transition"
                                    >
                                        Register
                                    </Link>
                                </>
                            )}
                        </nav>
                    </header>

                    <main className="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <Link
                            href="/trending-today"
                            className="bg-gray-800 rounded-lg shadow-lg p-6 hover:bg-gray-700 transition flex flex-col items-center"
                        >
                            <h3 className="text-lg font-semibold mb-2">Trending Today</h3>
                            <p className="text-gray-400 text-center">
                                Explore the latest trending movies of the day. Stay updated with what's popular right now.
                            </p>
                        </Link>

                        <Link
                            href="/trending-this-month"
                            className="bg-gray-800 rounded-lg shadow-lg p-6 hover:bg-gray-700 transition flex flex-col items-center"
                        >
                            <h3 className="text-lg font-semibold mb-2">Trending This Month</h3>
                            <p className="text-gray-400 text-center">
                                Discover the movies that have been trending throughout the month.
                            </p>
                        </Link>

                        <Link
                            href="/movie/{id}"
                            className="bg-gray-800 rounded-lg shadow-lg p-6 hover:bg-gray-700 transition flex flex-col items-center"
                        >
                            <h3 className="text-lg font-semibold mb-2">View Movie Details</h3>
                            <p className="text-gray-400 text-center">
                                Click here to view detailed information about a specific movie, including cast, synopsis, and more.
                            </p>
                        </Link>

                        <Link
                            href="/search"
                            className="bg-gray-800 rounded-lg shadow-lg p-6 hover:bg-gray-700 transition flex flex-col items-center"
                        >
                            <h3 className="text-lg font-semibold mb-2">Search for Movies</h3>
                            <p className="text-gray-400 text-center">
                                Use the search function to find movies. View a list of results and click on a movie to see more details.
                            </p>
                        </Link>
                    </main>

                    <footer className="py-16 text-center text-sm text-gray-500">
                        MovieApp v{laravelVersion} (PHP v{phpVersion})
                    </footer>
                </div>
            </div>
        </>
    );
}
