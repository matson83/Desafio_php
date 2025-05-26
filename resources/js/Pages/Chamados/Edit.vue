<template>
  <AppLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Editar Chamado</h2>
    </template>

    <div class="max-w-2xl p-6 mx-auto bg-white rounded shadow">
      <form @submit.prevent="submit" enctype="multipart/form-data">

        <!-- Erros -->
        <div v-if="form.hasErrors" class="mb-4 text-red-600">
          <div v-for="(error, key) in form.errors" :key="key">
            {{ error }}
          </div>
        </div>

        <!-- Título -->
        <div class="mb-4">
          <label class="block mb-1">Título</label>
          <input v-model="form.titulo" name="titulo" class="w-full px-3 py-2 border rounded" />
        </div>

        <!-- Descrição -->
        <div class="mb-4">
          <label class="block mb-1">Descrição</label>
          <textarea v-model="form.descricao" name="descricao" class="w-full px-3 py-2 border rounded"></textarea>
        </div>

        <!-- Categoria -->
        <div class="mb-4">
          <label class="block mb-1">Categoria</label>
          <select v-model="form.categoria" name="categoria" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option>TI</option>
            <option>Manutenção</option>
            <option>Suporte RH</option>
          </select>
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
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

// Props
const props = defineProps({
  chamado: Object,
})

// Formulário
const form = useForm({
  titulo: props.chamado.titulo ?? '',
  descricao: props.chamado.descricao ?? '',
  categoria: props.chamado.categoria ?? '',
  prioridade: props.chamado.prioridade ?? 'Baixa',
  anexo: null, // ⚠️ Corrigido: nunca use undefined, use null
})

// Upload de arquivo
function onFileChange(e) {
  form.anexo = e.target.files.length ? e.target.files[0] : null
}

// Envio
function submit() {
  // Mostra os valores reais
  console.log('Dados enviados:', {
    titulo: form.titulo,
    descricao: form.descricao,
    categoria: form.categoria,
    prioridade: form.prioridade,
    anexo: form.anexo,
  })

  form.patch(route('chamados.update', props.chamado.id), {
    onSuccess: () => {
      window.location = route('chamados.show', props.chamado.id)
    },
    onError: (errors) => {
      console.log('Erros:', errors)
    },
  })
}
</script>
