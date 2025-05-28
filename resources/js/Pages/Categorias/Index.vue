<template>
    <AppLayout>
        <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Chamados Técnicos
      </h2>
    </template>

    <div class="max-w-2xl p-6 mx-auto mt-2 bg-white rounded shadow">
    <h1 class="mb-4 text-2xl font-bold">Categorias</h1>


    <form @submit.prevent="addCategoria" class="flex gap-2 mb-6">
      <input
        v-model="form.nome"
        class="flex-1 px-3 py-2 border rounded"
        placeholder="Nova categoria"
      />
      <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded">
        Adicionar
      </button>
    </form>


    <ul>
      <li
        v-for="cat in categorias"
        :key="cat.id"
        class="flex items-center justify-between py-2 border-b"
      >
        <div v-if="editId !== cat.id">{{ cat.nome }}</div>
        <input
          v-else
          v-model="editNome"
          class="px-2 py-1 border rounded"
        />
        <div class="flex gap-2">
          <button
            v-if="editId !== cat.id"
            @click="startEdit(cat)"
            class="text-yellow-600"
          >
            Editar
          </button>
          <button
            v-else
            @click="saveEdit(cat)"
            class="text-green-600"
          >
            Salvar
          </button>
          <button
            @click="deleteCategoria(cat.id)"
            class="text-red-600"
          >
            Excluir
          </button>
        </div>
      </li>
    </ul>

    <button
      @click="voltarChamados"
      class="px-4 py-2 mt-6 text-white bg-gray-500 rounded"
    >
      Voltar aos Chamados
    </button>
  </div>
    </AppLayout>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  categorias: Array
})

const form = useForm({
  nome: ''
})

const editId = ref(null)
const editNome = ref('')

function addCategoria() {
  if (!form.nome) return
  form.post('/categorias', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    }
  })
}

function startEdit(cat) {
  editId.value = cat.id
  editNome.value = cat.nome
}

function saveEdit(cat) {
  router.put(`/categorias/${cat.id}`, { nome: editNome.value }, {
    preserveScroll: true,
    onSuccess: () => {
      editId.value = null
      editNome.value = ''
    }
  })
}

function deleteCategoria(id) {
  if (confirm('Deseja excluir essa categoria?')) {
    router.delete(`/categorias/${id}`, {
      preserveScroll: true
    })
  }
}

function voltarChamados() {
  router.visit('/chamados/create', {
    preserveScroll: true
  })
}
</script>
