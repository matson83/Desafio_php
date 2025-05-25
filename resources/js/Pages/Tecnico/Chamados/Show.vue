<template>
  <div class="max-w-4xl p-6 mx-auto bg-white border border-gray-200 rounded shadow">
    <h1 class="mb-4 text-2xl font-bold text-gray-800">Detalhes do Chamado</h1>

    <div class="space-y-4">
      <div>
        <h2 class="text-lg font-semibold text-gray-800">Título</h2>
        <p class="text-gray-600">{{ chamado.titulo }}</p>
      </div>

      <div>
        <h2 class="text-lg font-semibold text-gray-800">Descrição</h2>
        <p class="text-gray-600">{{ chamado.descricao }}</p>
      </div>

      <div>
        <h2 class="text-lg font-semibold text-gray-800">Categoria</h2>
        <p class="text-gray-600">{{ chamado.categoria }}</p>
      </div>

      <div>
        <h2 class="text-lg font-semibold text-gray-800">Status</h2>
        <p class="text-gray-600">{{ chamado.status }}</p>
      </div>

      <div>
        <h2 class="text-lg font-semibold text-gray-800">Responsável pelo Atendimento</h2>
        <p class="text-gray-600">{{ chamado.responsavel || 'Não atribuído' }}</p>
      </div>

      <div>
        <h2 class="text-lg font-semibold text-gray-800">Datas</h2>
        <p class="text-gray-600">Criado em: {{ formatDate(chamado.created_at) }}</p>
        <p class="text-gray-600">Última atualização: {{ formatDate(chamado.updated_at) }}</p>
      </div>
    </div>

    <div class="mt-6">
      <Link href="/tecnico/chamados" class="text-blue-600 hover:underline">Voltar para a lista de chamados</Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { format } from 'date-fns'

defineProps({ chamado: Object })

function formatDate(date) {
  return format(new Date(date), 'dd/MM/yyyy HH:mm')
}
</script>
