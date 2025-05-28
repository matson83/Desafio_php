<template>
  <AppLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Chamados Técnicos
      </h2>
    </template>

    <div class="max-w-6xl p-6 mx-auto mt-2">
      <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Chamados Técnicos</h1>
        <div class="flex items-center gap-4">
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

          <!-- Botão Excel -->
          <button
            @click="exportar('excel')"
            class="flex items-center p-2 bg-green-600 rounded shadow hover:bg-green-700"
            title="Exportar Excel"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <rect x="3" y="4" width="18" height="16" rx="2" fill="#22c55e"/>
              <text x="12" y="16" text-anchor="middle" fill="white" font-size="10" font-family="Arial" dy=".3em">XLS</text>
            </svg>
          </button>

          <!-- Botão PDF -->
          <button
            @click="exportar('pdf')"
            class="flex items-center p-2 bg-red-600 rounded shadow hover:bg-red-700"
            title="Exportar PDF"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <rect x="3" y="4" width="18" height="16" rx="2" fill="#ef4444"/>
              <text x="12" y="16" text-anchor="middle" fill="white" font-size="10" font-family="Arial" dy=".3em">PDF</text>
            </svg>
          </button>
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
                Categoria: {{ chamado.categoria?.nome ?? 'Sem categoria' }} | Prioridade: {{ chamado.prioridade }}
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
  router.get('/tecnico/chamados', {
    status: filters.value.status,
    prioridade: filters.value.prioridade,
  }, { preserveState: true })
}

function exportar(tipo) {
  const params = new URLSearchParams();
  if (filters.value.status) params.append('status', filters.value.status);
  if (filters.value.prioridade) params.append('prioridade', filters.value.prioridade);

  window.open(`/tecnico/chamados/export/${tipo}?${params.toString()}`, '_blank');
}
</script>
