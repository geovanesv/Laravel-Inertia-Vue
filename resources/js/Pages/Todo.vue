<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Buttom from '@/Components/PrimaryButton.vue'
import axios from 'axios';
import EachTodo from '@/Components/Todos/EachTodo.vue';
// import { createToaster } from "@meforma/vue-toaster";

const addTodo = () => {
    const title = prompt("Enter the todo title:")
    submitTodo(title)
}

const finishSubmit = (response) => {
    Inertia.visit('')
    const toaster = createToaster();
    toaster.success(response.data)
}
const submitTodo = (title) => {
    const formData = {
        "title": title
    }
    axios.post('/todos', formData)
        .then(res => finishSubmit(res))
        .catch(error => console.log(error))
}

const updateTodoSubmit = (id, title) => {
    const formData = {
        "id": id,
        "title": title
    }
    axios.post('/todos/update', formData)
        .then(res => finishSubmit(res))
        .catch(error => console.log(error.response))
}

const deleteTodo = (id,) => {
    axios.delete(`/todos/${id}`)
        .then(res => finishSubmit(res))
        .catch(error => console.log(error.response))
}

const changeStatus = (id, status) => {
    const formData = {
        "id": id,
        "status": status
    }
    axios.post('/todos/status', formData)
        .then(res => finishSubmit(res))
        .catch(error => console.log(error.response))
}

</script>

<template>
    <AppLayout title="todos">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    My Todos
                </h2>
                <Buttom type="button" v-on:click="addTodo" >Criar Tash</Buttom>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <EachTodo v-for="(todo, key) in $page.props.todos" :key="key" :todo="todo" :changeStatus="changeStatus"
                    :updateTodoSubmit="updateTodoSubmit" :deleteTodo="deleteTodo" />
            </div>
        </div>
    </AppLayout>
</template>
