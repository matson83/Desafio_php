<template>
  <AppLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Editar Chamado</h2>
    </template>

    <div class="max-w-2xl p-6 mx-auto mt-2 bg-white rounded shadow">
      <form @submit.prevent="submit" enctype="multipart/form-data">
        <div v-if="form.errors.error" class="p-4 mb-4 text-red-700 bg-red-100 rounded">
  {{ form.errors.error }}
</div>


        <!-- Título -->
        <div class="mb-4">
            <label class="block mb-1">Título</label>
            <input v-model="form.titulo" name="titulo" class="w-full px-3 py-2 border rounded" />
            <div v-if="form.errors.titulo" class="mt-1 text-sm text-red-600">
                {{ form.errors.titulo }}
            </div>
        </div>

        <!-- Descrição -->
        <div class="mb-4">
          <label class="block mb-1">Descrição</label>
          <textarea v-model="form.descricao" name="descricao" class="w-full px-3 py-2 border rounded"></textarea>
        </div>
        <div v-if="form.errors.descricao" class="mt-1 text-sm text-red-500">
  {{ form.errors.descricao }}
</div>

        <!-- Categoria -->
        <div class="mb-4">
          <label class="block mb-1">Categoria</label>
          <select v-model="form.categoria_id" class="w-full px-3 py-2 border rounded">
            <option value="">Selecione uma categoria</option>
            <option v-for="categoria in categorias"
                    :key="categoria.id"
                    :value="categoria.id">
              {{ categoria.nome }}
            </option>
          </select>
          <div v-if="form.errors.categoria_id" class="mt-1 text-sm text-red-600">
            {{ form.errors.categoria_id }}
          </div>
        </div>

        <!-- Prioridade -->
        <div class="mb-4">
          <label class="block mb-1">Prioridade</label>
          <select v-model="form.prioridade" name="prioridade" class="w-full px-3 py-2 border rounded">
            <option value="Baixa">Baixa</option>
            <option value="Média">Média</option>
            <option value="Alta">Alta</option>
          </select>
        </div>
        <div v-if="form.errors.prioridade" class="mt-1 text-sm text-red-500">
  {{ form.errors.prioridade }}
</div>

        <!-- Anexo -->
        <div class="mb-4">
          <label class="block mb-1">Anexo</label>

          <div v-if="props.chamado.anexo" class="mb-2">
            <a
              :href="`/storage/${props.chamado.anexo}`"
              target="_blank"
              class="text-blue-600 underline"
            >
              Ver anexo atual
            </a>
          </div>

          <input type="file" name="anexo" @change="onFileChange" class="w-full" />
        </div>

        <!-- Botão -->
        <button
          type="submit"
          class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
        >
          Salvar
        </button>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  chamado: Object,
  categorias: Array
})

const form = useForm({
  titulo: props.chamado.titulo || '',
  descricao: props.chamado.descricao || '',
  categoria_id: props.chamado.categoria_id || '',
  prioridade: props.chamado.prioridade || 'Baixa',
  anexo: null,
})

function onFileChange(e) {
  form.anexo = e.target.files[0] || null
}

function submit() {
  form.patch(route('chamados.update', props.chamado.id), {
    preserveScroll: true,
  })
}
</script>
