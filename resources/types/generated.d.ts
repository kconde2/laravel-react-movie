declare namespace Domain.Movies.Data {
export type TrendingMoviesStats = {
dailyMovieCount: number;
weeklyMovieCount: number;
};
}
declare namespace Domain.Movies.Enums {
export type MovieTimeWindow = 'day' | 'week';
}
