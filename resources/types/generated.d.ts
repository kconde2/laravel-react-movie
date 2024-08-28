declare namespace Domain.Movies.Data {
export type TrendingMoviesStats = {
dailyMovieCount: number;
weeklyMovieCount: number;
};
}
declare namespace Domain.Movies.Data.Output {
export type MovieResourceData = {
id: number;
tmdbId: number;
title: string;
originalTitle: string;
overview: string;
posterPath: string;
posterUrl: string;
mediaType: string;
backdropPath: string;
backdropUrl: string;
isAdult: boolean;
originalLanguage: string;
popularity: number;
releaseDate: string;
isVideo: boolean;
voteAverage: number;
voteCount: number;
timeWindow: string;
createdAt: string;
updatedAt: string;
};
}
declare namespace Domain.Movies.Enums {
export type MovieTimeWindow = 'day' | 'week';
}
