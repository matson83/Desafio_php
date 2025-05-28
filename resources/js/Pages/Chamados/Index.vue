<template>
  <AppLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Chamados Técnicos
      </h2>
    </template>

    <div class="max-w-5xl p-6 mx-auto mt-2">
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Meus Chamados</h1>
        <Link href="/chamados/create" class="px-4 py-2 text-white bg-blue-600 rounded shadow hover:bg-blue-700">
          Novo Chamado
        </Link>
      </div>

      <div v-if="chamados.length === 0" class="py-10 text-center text-gray-500">
        Nenhum chamado encontrado.
      </div>

      <div v-else class="grid gap-4">
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
              <p class="mt-1 text-sm font-medium">
                Status: <span class="text-blue-600">{{ chamado.status }}</span>
              </p>
            </div>
            <Link :href="`/chamados/${chamado.id}`" class="text-sm text-blue-600 hover:underline">
              Visualizar
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  chamados: Array
});
</script>
