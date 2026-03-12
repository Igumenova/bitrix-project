<template>
  <div class="dropdown-select" ref="root">
    <label v-if="label" class="label">{{ label }}</label>

    <div class="dropdown">
      <div class="selected" @click="toggle">
        <span class="value">
          {{ selectedLabel || placeholder }}
        </span>

        <div class="arrow" :class="{ open }">
          <img :src="Chevron" alt="chevron" />
        </div>
      </div>

      <Transition name="dropdown">
        <div v-if="open" class="dropdown-menu" @click.stop>
          <input
            v-if="searchable"
            v-model="search"
            type="text"
            :placeholder="searchPlaceholder"
            class="search"
          />

          <div class="options">
            <div
              v-if="clearable"
              class="option"
              :class="{ active: isSelected('') }"
              @click="selectClear"
            >
              {{ clearText }}
            </div>

            <div
              v-for="option in filteredOptions"
              :key="option[valueKey]"
              class="option"
              :class="{ active: isSelected(option[valueKey]) }"
              @click="select(option[valueKey])"
            >
              {{ option[labelKey] }}
            </div>

            <div v-if="filteredOptions.length === 0" class="empty">Ничего не найдено</div>
          </div>
        </div>
      </Transition>
    </div>
  </div>
</template>

<script setup>
  import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
  import Chevron from '../../assets/icons/chevron-down.svg'

  const props = defineProps({
    modelValue: [String, Number, Array],
    multiple: { type: Boolean, default: false },

    options: { type: Array, default: () => [] },

    label: String,
    placeholder: { default: 'Выберите' },

    searchable: { default: true },
    searchPlaceholder: { default: 'Поиск...' },

    clearable: { default: true },
    clearText: { default: 'Все' },

    labelKey: { default: 'name' },
    valueKey: { default: 'id' }
  })

  const emit = defineEmits(['update:modelValue'])

  const open = ref(false)
  const search = ref('')
  const root = ref(null)

  const toggle = () => {
    open.value = !open.value
  }

  const select = (value) => {
    if (props.multiple) {
      let newValue = Array.isArray(props.modelValue) ? [...props.modelValue] : []
      const index = newValue.indexOf(value)
      if (index >= 0) {
        newValue.splice(index, 1)
      } else {
        newValue.push(value)
      }
      emit('update:modelValue', newValue)
    } else {
      emit('update:modelValue', value)
      open.value = false
    }
    search.value = ''
  }

  const selectClear = () => {
    if (props.multiple) {
      emit('update:modelValue', [])
    } else {
      emit('update:modelValue', '')
    }
    open.value = false
    search.value = ''
  }

  const isSelected = (value) => {
    if (props.multiple) {
      return Array.isArray(props.modelValue) && props.modelValue.includes(value)
    } else {
      return props.modelValue === value
    }
  }

  const filteredOptions = computed(() => {
    if (!props.searchable || !search.value) return props.options
    return props.options.filter((o) =>
      o[props.labelKey].toLowerCase().includes(search.value.toLowerCase())
    )
  })

  const selectedLabel = computed(() => {
    if (props.multiple) {
      const labels = props.options
        .filter(
          (o) => Array.isArray(props.modelValue) && props.modelValue.includes(o[props.valueKey])
        )
        .map((o) => o[props.labelKey])
      return labels.join(', ')
    } else {
      const found = props.options.find((o) => o[props.valueKey] == props.modelValue)
      return found?.[props.labelKey]
    }
  })

  const handleClickOutside = (e) => {
    if (root.value && !root.value.contains(e.target)) {
      open.value = false
    }
  }

  onMounted(() => {
    document.addEventListener('click', handleClickOutside)
  })

  onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside)
  })
</script>

<style scoped lang="scss">
  @import './dropdown-select.scss';
</style>
