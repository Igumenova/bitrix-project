import js from '@eslint/js'
import vue from 'eslint-plugin-vue'
import prettier from 'eslint-plugin-prettier'
import vueParser from 'vue-eslint-parser'

export default [
  js.configs.recommended,

  {
    files: ['**/*.vue', '**/*.js'],
    languageOptions: {
      parser: vueParser
    },

    plugins: {
      vue,
      prettier
    },

    rules: {
      ...vue.configs['vue3-recommended'].rules,

      'prettier/prettier': 'error',

      'vue/multi-word-component-names': 'off',
      'no-unused-vars': 'warn'
    }
  }
]
