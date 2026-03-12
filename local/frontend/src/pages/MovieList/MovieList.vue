<template>
  <div class="container">
    <MovieFilters
      :genres="genres"
      :tags="tags"
      :countries="countries"
      :filters="filters"
      @update:search="filters.search = $event"
      @update:filters="filters = $event"
    />

    <MovieGrid :movies="movies" />

    <div v-if="!loading && movies.length === 0" class="message">
      По вашему запросу ничего не найдено
    </div>

    <div v-if="loading" class="message">Загрузка...</div>

    <button class="btn-more" @click="loadMore" v-if="!loading && page < totalPages">
      Загрузить ещё
    </button>
  </div>
</template>

<script setup>
  import { ref, reactive, onMounted, watch } from 'vue'
  import { getMovies, getGenres, getTags, getCountries } from '../../api/movies.js'
  import MovieGrid from '../../components/MovieGrid/MovieGrid.vue'
  import MovieFilters from '../../components/MovieFilters/MovieFilters.vue'

  const movies = ref([])
  const genres = ref([])
  const tags = ref([])
  const countries = ref([])
  const loading = ref(false)
  const page = ref(1)
  const totalPages = ref(1)

  const filters = reactive({
    genreId: null,
    country: null,
    tags: [],
    search: ''
  })

  const loadMovies = async () => {
    loading.value = true
    const data = await getMovies({ page: page.value, ...filters })
    if (page.value === 1) movies.value = data.items
    else movies.value.push(...data.items)
    totalPages.value = data.totalPages
    loading.value = false
  }

  const loadMore = () => {
    if (page.value < totalPages.value) {
      page.value++
      loadMovies()
    }
  }

  watch(
    filters,
    () => {
      page.value = 1
      loadMovies()
    },
    { deep: true }
  )

  onMounted(async () => {
    genres.value = await getGenres()
    tags.value = await getTags()
    countries.value = await getCountries()
    await loadMovies()
  })
</script>

<style lang="scss">
  @import './movieList.scss';
</style>
