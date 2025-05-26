<template>
  <transition name="fade">
    <div
      v-if="visible"
      :class="[
        'fixed top-6 left-1/2 transform -translate-x-1/2 z-50 px-6 py-3 rounded shadow-lg flex items-center gap-2',
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
      ]"
      role="alert"
    >
      <span v-if="type === 'success'">
        <svg class="inline w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
      </span>
      <span v-else>
        <svg class="inline w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
      </span>
      <span>{{ message }}</span>
      <button @click="visible = false" class="ml-4 text-white hover:text-gray-200">&times;</button>
    </div>
  </transition>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'

const props = defineProps({
  message: String,
  type: { type: String, default: 'success' }
})

const visible = ref(!!props.message)

watch(() => props.message, (val) => {
  visible.value = !!val
  if (val) {
    setTimeout(() => visible.value = false, 4000)
  }
})

onMounted(() => {
  if (props.message) {
    setTimeout(() => visible.value = false, 4000)
  }
})
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
