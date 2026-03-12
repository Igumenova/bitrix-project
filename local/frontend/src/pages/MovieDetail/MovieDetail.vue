<template>
  <div class="movie-detail" v-if="movie">
    <button class="back-btn" @click="$router.back()">← Назад</button>

    <div class="content">
      <div class="poster">
        <img v-if="movie.detailPicture" :src="movie.detailPicture" :alt="movie.title" />
      </div>

      <div class="info">
        <h1 class="title">
          {{ movie.title }} <span v-if="movie.year">({{ movie.year }})</span>
        </h1>
        <p class="description">{{ movie.details }}</p>

        <MetaList
          :meta="{
            Жанр: Array.isArray(movie.genre) ? movie.genre.join(', ') : movie.genre,
            Режиссёр: movie.director,
            Страна: Array.isArray(movie.country) ? movie.country.join(', ') : movie.country,
            Продолжительность: movie.duration ? movie.duration + ' мин' : null,
            'Возрастной рейтинг': movie.age ? movie.age + '+' : null
          }"
        />

        <div class="tags-container">
          <MovieTags v-if="movie.tags && movie.tags.length" :tags="movie.tags" />
        </div>
      </div>
    </div>
  </div>

  <div v-else class="loading">Загрузка...</div>
</template>

<script setup>
  import { ref, onMounted } from 'vue'
  import { useRoute } from 'vue-router'
  import { getMovieDetail } from '../../api/movies'
  import MovieTags from '../../components/MovieTags/MovieTags.vue'
  import MetaList from '../../components/MetaList/MetaList.vue'

  const route = useRoute()
  const movie = ref(null)

  onMounted(async () => {
    const id = route.params.id
    movie.value = await getMovieDetail(id)
  })
</script>

<style scoped lang="scss">
  @import './movieDetail.scss';
</style>
