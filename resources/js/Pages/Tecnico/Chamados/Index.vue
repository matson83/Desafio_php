<template>
  <AppLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Chamados Técnicos
      </h2>
    </template>

    <div class="max-w-6xl p-6 mx-auto">
      <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Chamados Técnicos</h1>
        <div class="flex gap-4">
          <select v-model="filters.status" @change="applyFilters" class="px-3 py-2 border rounded">
            <option value="">Todos os Status</option>
            <option>Aberto</option>
            <option>Em atendimento</option>
            <option>Resolvido</option>
            <option>Fechado</option>
          </select>

          <select v-model="filters.prioridade" @change="applyFilters" class="px-3 py-2 border rounded">
            <option value="">Todas as Prioridades</option>
            <option>Baixa</option>
            <option>Média</option>
            <option>Alta</option>
          </select>
        </div>
      </div>

      <div v-if="chamados.length === 0" class="py-10 text-center text-gray-500">
        Nenhum chamado encontrado com os filtros aplicados.
      </div>

      <div v-else class="space-y-4">
        <div
          v-for="chamado in chamados"
          :key="chamado.id"
          class="p-4 transition bg-white border border-gray-100 rounded shadow hover:shadow-md"
        >
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-lg font-semibold text-gray-800">{{ chamado.titulo }}</h2>
              <p class="mt-1 text-sm text-gray-500">
                Categoria: {{ chamado.categoria }} | Prioridade: {{ chamado.prioridade }}
              </p>
              <p class="mt-1 text-sm font-medium">Status: <span class="text-blue-600">{{ chamado.status }}</span></p>
            </div>
            <Link :href="`/tecnico/chamados/${chamado.id}`" class="text-sm text-blue-600 hover:underline">Ver Detalhes</Link>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { router, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';



defineProps({ chamados: Array })

const filters = ref({
  status: '',
  prioridade: '',
})

function applyFilters() {
  router.get('/tecnico/chamados', filters, { preserveState: true })
}
</script>
