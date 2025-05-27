<template>
  <AppLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Gerenciar Usuários</h2>
    </template>
    <div class="max-w-4xl p-6 mx-auto bg-white rounded shadow">
      <table class="w-full table-auto">
        <thead>
          <tr>
            <th class="px-2 py-1">Nome</th>
            <th class="px-2 py-1">E-mail</th>
            <th class="px-2 py-1">Perfil</th>
            <th class="px-2 py-1">Status</th>
            <th class="px-2 py-1">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="usuario in usuarios" :key="usuario.id">
            <td class="px-2 py-1">{{ usuario.name }}</td>
            <td class="px-2 py-1">{{ usuario.email }}</td>
            <td class="px-2 py-1">
              <select v-model="usuario.perfil" @change="alterarPerfil(usuario)">
                <option value="colaborador">Colaborador</option>
                <option value="tecnico">Técnico</option>
              </select>
            </td>
            <td class="px-2 py-1">
              <span :class="usuario.ativo ? 'text-green-600' : 'text-red-600'">
                {{ usuario.ativo ? 'Ativo' : 'Inativo' }}
              </span>
            </td>
            <td class="px-2 py-1">
              <button
                @click="toggleAtivo(usuario)"
                class="px-2 py-1 text-xs text-white rounded"
                :class="usuario.ativo ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'"
              >
                {{ usuario.ativo ? 'Desativar' : 'Reativar' }}
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({ usuarios: Array })

function toggleAtivo(usuario) {
  router.patch(route('tecnico.usuarios.toggle', usuario.id))
}

function alterarPerfil(usuario) {
  router.patch(route('tecnico.usuarios.perfil', usuario.id), {
    perfil: usuario.perfil,
  })
}
</script>
