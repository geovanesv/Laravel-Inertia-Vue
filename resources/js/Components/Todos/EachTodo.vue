<script setup>
import { ref } from 'vue'
const props = defineProps({
    todo: Object,
    changeStatus: Function,
    updateTodoSubmit: Function,
    deleteTodo: Function
})
const status = ref(props.todo.status ? true : false)

const toggleInput = () => {
    status.value = !status.value
    props.changeStatus(props.todo.id, status.value)
}

const updateTodo = () => {
    const title = prompt("Título atualizado com sucesso", props.todo.title)
    props.updateTodoSubmit(props.todo.id, title)
}

const removeTodo = () => {
    if(confirm("tem certeza que deseja remover?")){
        props.deleteTodo(props.todo.id)
    }
}

</script>

<template>
    <div v-on:click="toggleInput"
        class="bg-white shadow-sm sm:rounded-lg mb-4 flex px-5 py-4 items-center cursor-pointer justify-between">
        <div class="flex items-center">
            <input v-model="status" :value="status" type="checkbox" name="status" class="mr-4 text-indigo-600 bg-gray-100 rounded border-gray-300 focus:ring-indigo-500 focus:ring-2">
            <div class="select-none">{{ todo.title }}</div>
        </div>
        <div class="flex space-x-4 text-sm">
            <button v-on:click.stop="updateTodo">Editar</button>
            <button v-on:click.stop="removeTodo" class="text-red-600">Apagar</button>
        </div>
    </div>
</template>
