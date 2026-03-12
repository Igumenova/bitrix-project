<template>
  <div class="filters">
    <input
      type="text"
      v-model="localSearch"
      placeholder="Поиск по названию..."
      class="search-input"
    />

    <div class="dropdowns-container">
      <DropdownSelect v-model="filters.genreId" :options="genres" placeholder="Все жанры" />

      <DropdownSelect v-model="filters.country" :options="countries" placeholder="Все страны" />

      <DropdownSelect v-model="filters.tags" :options="tags" placeholder="Все теги" multiple />
    </div>
  </div>
</template>

<script setup>
  import { ref, watch } from 'vue'
  import { debounce } from 'lodash-es'
  import DropdownSelect from '../DropdownSelect/DropdownSelect.vue'

  const props = defineProps({
    genres: Array,
    tags: Array,
    countries: Array,
    filters: Object
  })

  const emit = defineEmits(['update:search', 'update:filters'])

  const localSearch = ref(props.filters.search || '')

  const debouncedSearch = debounce((val) => {
    emit('update:search', val)
  }, 150)

  watch(localSearch, (val) => {
    debouncedSearch(val)
  })

  watch(
    () => props.filters,
    (val) => {
      emit('update:filters', val)
    },
    { deep: true }
  )
</script>

<style scoped lang="scss">
  @import './movieFilters.scss';
</style>
