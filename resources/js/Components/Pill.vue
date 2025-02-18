<script setup>

import {Link} from "@inertiajs/vue3";

const props = defineProps({
  href: {
    type: String,
    required: true,
  },
  filled: {
    type: Boolean,
    default: false,
  }
});
</script>

<template>
  <Link :href="href"
        :class="{' bg-blue-600 !text-indigo-50' : filled}"
        class="mb-2 rounded-full py-0.5 px-2 border border-blue-500 text-blue-500 hover:bg-blue-600 hover:text-indigo-50 justify-end"
  >
    <slot></slot>
  </Link>
</template>

<style scoped>

</style>