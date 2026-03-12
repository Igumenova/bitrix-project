<template>
  <router-link :to="'/movie/' + movie.id" class="card-link">
    <div class="movie-card">
      <div class="img-wrapper">
        <img v-if="movie.previewPicture" :src="movie.previewPicture" loading="lazy" />

        <div class="overlay">
          <h3 class="title">{{ movie.title }} ({{ movie.year }})</h3>
          <p class="description">{{ movie.description }}</p>
        </div>
      </div>

      <div class="info">
        <h3 class="title">{{ movie.title }} ({{ movie.year }})</h3>
        <p class="description">{{ movie.description }}</p>
      </div>
    </div>
  </router-link>
</template>

<script setup>
  import { defineProps } from 'vue'

  const props = defineProps({
    movie: { type: Object, required: true }
  })
</script>

<style lang="scss">
  @import './MovieCard.scss';
</style>
