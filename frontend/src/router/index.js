import { createRouter, createWebHistory } from 'vue-router'
import MovieList from '../pages/MovieList/MovieList.vue'
import MovieDetail from '../pages/MovieDetail/MovieDetail.vue'

const routes = [
  { path: '/', component: MovieList },
  { path: '/movie/:id', component: MovieDetail }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
