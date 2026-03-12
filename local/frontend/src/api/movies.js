export const getMovies = (params = {}) => {
  return BX.ajax.runComponentAction(
    'test:movies.rest',
    'list',
    {
      mode: 'class',
      data: params
    }
  ).then(res => res.data)
}

export const getGenres = () => {
  return BX.ajax.runComponentAction(
    'test:movies.rest',
    'genres',
    { mode: 'class' }
  ).then(res => res.data)
}

export const getTags = () => {
  return BX.ajax.runComponentAction(
    'test:movies.rest',
    'tags',
    { mode: 'class' }
  ).then(res => res.data)
}

export const getCountries = () => {
  return BX.ajax.runComponentAction(
    'test:movies.rest',
    'countries',
    { mode: 'class' }
  ).then(res => res.data)
}

export const getMovieDetail = (id) => {
  return BX.ajax.runComponentAction(
    'test:movies.rest',
    'detail',
    {
      mode: 'class',
      data: { id }
    }
  ).then(res => res.data)
}


//через модуль

// export const getMovies = ({
//   page = 1,
//   genreId = null,
//   country = null,
//   tags = [],
//   search = '',
//   pageSize = 9
// } = {}) => {
//   return BX.ajax
//     .runAction('test:movies.movie.list', {
//       data: {
//         page,
//         genreId,
//         country,
//         tags,
//         search,
//         pageSize
//       }
//     })
//     .then((res) => res.data)
// }

// export const getGenres = () => {
//   return BX.ajax.runAction('test:movies.movie.genres').then((res) => res.data)
// }

// export const getTags = () => {
//   return BX.ajax.runAction('test:movies.movie.tags').then((res) => res.data)
// }

// export const getCountries = () => {
//   return BX.ajax.runAction('test:movies.movie.countries').then((res) => res.data)
// }

// export const getMovieDetail = (id) => {
//   return BX.ajax
//     .runAction('test:movies.movie.detail', {
//       data: { id }
//     })
//     .then((res) => res.data)
// }
