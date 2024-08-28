import { FormEvent } from "react";
import { Head, useForm, router } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { PageProps } from "@/types";

export default function EditMovie({
    auth,
    movie,
}: PageProps<{ movie: Domain.Movies.Data.Output.MovieResourceData }>) {
    const { data, setData, put, processing, errors } = useForm({
        title: movie.title || "",
        overview: movie.overview || "",
    });

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        put(route("movies.update", movie.id), {
            onSuccess: () => {
                router.get(route("movies.detail", movie.id));
            },
        });
    };

    return (
        <AuthenticatedLayout user={auth.user} header={<h2>Edit Movie</h2>}>
            <Head title={`Edit ${movie.title}`} />
            <div className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form onSubmit={handleSubmit} className="space-y-4">
                        <div>
                            <label
                                htmlFor="title"
                                className="block text-sm font-medium text-gray-700"
                            >
                                Title
                            </label>
                            <input
                                id="title"
                                type="text"
                                value={data.title}
                                onChange={(e) =>
                                    setData("title", e.target.value)
                                }
                                required
                                className="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            />
                            {errors.title && (
                                <div className="text-red-600 text-sm">
                                    {errors.title}
                                </div>
                            )}
                        </div>

                        <div>
                            <label
                                htmlFor="overview"
                                className="block text-sm font-medium text-gray-700"
                            >
                                Overview
                            </label>
                            <textarea
                                id="overview"
                                value={data.overview}
                                onChange={(e) =>
                                    setData("overview", e.target.value)
                                }
                                className="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            />
                            {errors.overview && (
                                <div className="text-red-600 text-sm">
                                    {errors.overview}
                                </div>
                            )}
                        </div>

                        <div>
                            <button
                                type="submit"
                                disabled={processing}
                                className="px-4 py-2 bg-blue-600 text-white rounded-md"
                            >
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
