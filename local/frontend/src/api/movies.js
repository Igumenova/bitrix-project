export const getMovies = ({
  page = 1,
  genreId = null,
  country = null,
  tags = [],
  search = '',
  pageSize = 9
} = {}) => {
  return BX.ajax
    .runAction('test:movies.movie.list', {
      data: {
        page,
        genreId,
        country,
        tags,
        search,
        pageSize
      }
    })
    .then((res) => res.data)
}

export const getGenres = () => {
  return BX.ajax.runAction('test:movies.movie.genres').then((res) => res.data)
}

export const getTags = () => {
  return BX.ajax.runAction('test:movies.movie.tags').then((res) => res.data)
}

export const getCountries = () => {
  return BX.ajax.runAction('test:movies.movie.countries').then((res) => res.data)
}

export const getMovieDetail = (id) => {
  return BX.ajax
    .runAction('test:movies.movie.detail', {
      data: { id }
    })
    .then((res) => res.data)
}
