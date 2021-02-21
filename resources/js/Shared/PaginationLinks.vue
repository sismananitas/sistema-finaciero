<template>
  <div class="mt-6 -mb-1 flex flex-wrap p-4 bg-white font-bold">
    <template v-for="(link, key) in links">
      <div v-if="link.url === null" :key="link.id" class="mr-1 mb-1 px-4 py-3 text-sm border rounded text-gray-400">{{ link.label }}</div>
      <inertia-link
        v-else
        preserveScroll
        :key="key"
        class="mr-1 mb-1 px-4 py-3 text-sm border rounded hover:bg-gray-100 focus:border-indigo-500 focus:text-indigo-500"
        :class="{ 'bg-blue-500': link.active, 'text-white': link.active, 'hover:bg-blue-500': link.active }"
        :href="link.url">{{ link.label }}</inertia-link>
    </template>
  </div>
</template>

<script>
export default {
  props: {
    links: Array,
  },
}
</script>