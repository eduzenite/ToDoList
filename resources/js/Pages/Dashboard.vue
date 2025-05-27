<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import { ref } from 'vue';
import axios from 'axios';

const { props } = usePage();
const lang = props.lang;

defineProps({
  todoList: {
    type: Object,
    required: true
  },
  newsList: {
    type: Object,
    required: true
  },
  todoStatus: {
    type: Array,
    required: true
  },
});

const showCreateModal = ref(false);
const showEditModal = ref(false);

const newTask = ref({
  title: '',
  description: '',
  status: 'pendente',
  due_date: '',
});

const editTask = ref({
  id: null,
  title: '',
  description: '',
  status: 'pendente',
  due_date: '',
});

const localTodoList = ref([...props.todoList.data]);

function openEditModal(task) {
  editTask.value = { ...task };
  showEditModal.value = true;
}

async function createTask() {
  try {
    console.log('Criando:', newTask.value);

    const response = await axios.post('/todo', newTask.value);
    console.log('Tarefa criada com sucesso:', response.data.data);

    localTodoList.value.unshift(response.data.data);

    newTask.value = {
      title: '',
      description: '',
      status: 'pendente',
      due_date: ''
    };

    showCreateModal.value = false;

  } catch (error) {
    console.error('Erro ao criar tarefa:', error);
  }
}

async function updateTask() {
  try {
    console.log('Atualizando:', editTask.value);

    const response = await axios.put(`/todo/${editTask.value.id}`, editTask.value);

    const index = localTodoList.value.findIndex(task => task.id === editTask.value.id);
    if (index !== -1) {
      localTodoList.value[index] = response.data.data;
    }

    showEditModal.value = false;

    editTask.value = {
      id: null,
      title: '',
      description: '',
      status: 'pendente',
      due_date: ''
    };

  } catch (error) {
    console.error('Erro ao atualizar tarefa:', error);
  }
}

function deleteTask(id) {
  if (confirm('Tem certeza que deseja deletar esta tarefa?')) {
    axios.delete(`/todo/${id}`)
        .then(() => {
          console.log('Tarefa deletada com sucesso!');
          localTodoList.value = localTodoList.value.filter(task => task.id !== id);
        })
        .catch(error => {
          console.error('Erro ao deletar tarefa:', error);
        });
  }
}
</script>


<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between">
          <h2 class="text-xl font-semibold mb-3">Tarefas</h2>
          <button @click="showCreateModal = true"
                  class="inline-flex items-center px-4 py-2 mb-3 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
            Criar tarefa
          </button>
        </div>

        <!-- Modal de Criação -->
        <div v-if="showCreateModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
          <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Criar Tarefa</h3>

            <form @submit.prevent="createTask">
              <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Título <span class="text-red-700">*</span></label>
                <input v-model="newTask.title" type="text" class="w-full border rounded px-3 py-2" required>
              </div>

              <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Descrição</label>
                <textarea v-model="newTask.description" class="w-full border rounded px-3 py-2"></textarea>
              </div>

              <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Status</label>
                <select v-model="newTask.status" class="w-full border rounded px-3 py-2">
                  <option v-for="status in todoStatus" :key="status" :value="status">
                    {{ lang.todo[status] }}
                  </option>
                </select>
              </div>

              <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Data de Vencimento</label>
                <input v-model="newTask.due_date" type="date" class="w-full border rounded px-3 py-2">
              </div>

              <div class="flex justify-end">
                <button type="button" @click="showCreateModal = false"
                        class="mr-2 px-4 py-2 text-sm rounded border hover:bg-gray-100">
                  Cancelar
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
                  Criar
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Modal de Edição -->
        <div v-if="showEditModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
          <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Editar Tarefa</h3>

            <form @submit.prevent="updateTask">
              <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Título</label>
                <input v-model="editTask.title" type="text" class="w-full border rounded px-3 py-2">
              </div>

              <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Descrição</label>
                <textarea v-model="editTask.description" class="w-full border rounded px-3 py-2"></textarea>
              </div>

              <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Status</label>
                <select v-model="editTask.status" class="w-full border rounded px-3 py-2">
                  <option v-for="status in todoStatus" :key="status" :value="status" :selected="editTask.status === status">
                    {{ lang.todo[status] }}
                  </option>
                </select>
              </div>

              <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Data de Vencimento</label>
                <input v-model="editTask.due_date" type="date" class="w-full border rounded px-3 py-2">
              </div>

              <div class="flex justify-end">
                <button type="button" @click="showEditModal = false"
                        class="mr-2 px-4 py-2 text-sm rounded border hover:bg-gray-100">
                  Cancelar
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700">
                  Salvar
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Lista de Tarefas -->
        <div v-if="localTodoList.length"
             class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div v-for="todo in localTodoList" :key="todo.id"
               class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
            <div class="p-4">
              <h3 class="text-lg font-semibold mb-2">{{ todo.title }}</h3>
              <p v-if="todo.description" class="text-gray-700 mb-4">{{ todo.description }}</p>
              <div class="flex justify-between">
                <p class="text-gray-700 mb-4">{{ lang.todo[todo.status] }}</p>
                <p v-if="todo.due_date" class="text-gray-700 mb-4">
                  {{ dayjs(todo.due_date).format('DD/MM/YYYY') }}
                </p>
              </div>
              <button @click="openEditModal(todo)"
                      class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                Ver detalhes
                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
              </button>
              <button @click="deleteTask(todo.id)"
                      class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700 transition ml-2">
                Deletar
                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
            </div>
          </div>
        </div>

        <div v-else class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden mb-14">
          <div class="p-4">
            <h3 class="text-lg font-semibold mb-2">Nenhuma tarefa encontrada</h3>
            <p class="text-gray-700 mb-4">Você ainda não tem tarefas.</p>
          </div>
        </div>

        <!-- Notícias -->
        <h2 class="text-xl font-semibold mb-5">Notícias</h2>

        <div v-if="newsList.articles && newsList.articles.length"
             class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div v-for="article in newsList.articles" :key="article.url"
               class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
            <img :src="article.urlToImage"
                 :alt="article.title"
                 class="w-full h-40 object-cover">
            <div class="p-4">
              <p class="text-gray-700 mb-4">{{ article.title }}</p>
              <a :href="article.url" target="_blank"
                 class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                Leia mais
                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
              </a>
            </div>
          </div>
        </div>

        <div v-else class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden mb-14">
          <div class="p-4">
            <h3 class="text-lg font-semibold mb-2">Nenhuma notícia encontrada</h3>
            <p class="text-gray-700 mb-4">Sem notícias disponíveis no momento.</p>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
