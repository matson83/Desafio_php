<template>
    <AppLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Chamados Técnicos
      </h2>
    </template>

  <div class="max-w-3xl p-6 mx-auto mt-2 bg-white rounded shadow">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">Abrir Novo Chamado</h1>

    <form @submit.prevent="submit" class="space-y-5">
      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Título</label>
        <input v-model="form.titulo" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />
      </div>

      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Descrição</label>
        <textarea v-model="form.descricao" rows="4" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />
      </div>

      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Categoria</label>
        <div class="flex gap-2">
          <select v-model="form.categoria_id" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option v-for="cat in categorias" :key="cat.id" :value="cat.id">{{ cat.nome }}</option>
          </select>
          <button type="button" @click="router.visit('/categorias')" class="px-2 py-1 text-white bg-gray-500 rounded">
            Gerenciar Categorias
          </button>
        </div>

      </div>

      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Prioridade</label>
        <select v-model="form.prioridade" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option>Baixa</option>
          <option>Média</option>
          <option>Alta</option>
        </select>
      </div>

      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Anexo (opcional)</label>
        <input type="file" @change="handleFile" class="w-full px-3 py-2 border rounded" />
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-5 py-2 text-white bg-blue-600 rounded shadow hover:bg-blue-700">
          Salvar Chamado
        </button>
      </div>
    </form>
  </div>
  </AppLayout>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';

const form = useForm({
  titulo: '',
  descricao: '',
  categoria_id: '',
  prioridade: 'Média',
  anexo: null,
})

const categorias = ref([])

onMounted(fetchCategorias)

async function fetchCategorias() {
  const res = await fetch('/api/categorias')
  categorias.value = await res.json()

  if (categorias.value.length && !form.categoria_id) {
    form.categoria_id = categorias.value[0].id
  }
}


function handleFile(e) {
  form.anexo = e.target.files[0]
}

function submit() {
  form.post('/chamados', {
    forceFormData: true,
  })
}
</script>
