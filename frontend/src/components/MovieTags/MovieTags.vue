<template>
  <span class="tags">
    <span v-for="tag in tags" :key="tag" class="tag">{{ tag }}</span>
  </span>
</template>

<script setup>
  defineProps({
    tags: {
      type: Array,
      default: () => []
    }
  })
</script>

<style scoped lang="scss">
  @import './movieTags.scss';
</style>
