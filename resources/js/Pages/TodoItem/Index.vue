<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { reactive, ref, onMounted } from 'vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import debounce from 'lodash.debounce'

const props = defineProps({
    items: {
        type: Object,
    },
});

let todoItems = props.items;

const handleScroll = debounce((e) => {
    let pixelsFromBottom = document.documentElement.offsetHeight - document.documentElement.scrollTop - window.innerHeight;
    if (pixelsFromBottom < 200) {
        axios.get(todoItems.next_page_url).then(response =>  {
            todoItems  = reactive({
                ...response.data,
                data: [...todoItems.data,  ...response.data.data]
            });
        })
    }
}, 100);

onMounted(() => {
    //  window.addEventListener("scroll", handleScroll);  // variable not rending
});

const form = useForm({});
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-block">Todo Items</h2>

            <Link :href="route('todo.create')" class="float-right">Create New</Link>
        </template>

        <div class="py-12" ref="scrollComponent">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden pb-3 shadow-sm sm:rounded-lg">
                    <table class="w-full text-center space-y-6">
                        <thead class="border-b font-medium">
                        <tr>
                            <th class="px-6 py-4 text-left">Title</th>
                            <th class="px-6 py-4">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="item in todoItems.data"
                            :key="item.id"
                            class="border-b dark:border-neutral-500">
                            <td v-text="item.title" class="whitespace-nowrap px-6 py-4 text-left"/>
                            <td class="whitespace-nowrap px-6 py-4">
                                <Link :href="route('todo.edit', item.id)">Edit</Link>
                                -
                                <a @click="form.delete(route('todo.destroy', item.id))">Delete</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <pagination class="mt-6" :links="items.links"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
