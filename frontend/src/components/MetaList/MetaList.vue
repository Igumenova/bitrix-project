<template>
  <ul class="meta-list">
    <li v-for="(value, key) in meta" :key="key">
      <strong>{{ key }}:</strong> {{ value || '—' }}
    </li>
  </ul>
</template>

<script setup>
  defineProps({
    meta: {
      type: Object,
      required: true
    }
  })
</script>

<style scoped lang="scss">
  @import './metaList.scss';
</style>
