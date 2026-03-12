<template>
  <div class="wrapper">
    <MovieCard v-for="movie in movies" :key="movie.id" :movie="movie" />
  </div>
</template>

<script setup>
  import MovieCard from '../MovieCard/MovieCard.vue'

  defineProps({
    movies: Array
  })
</script>

<style scoped lang="scss">
  @import './movieGrid.scss';
</style>
