<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    links: {
        type: Array,
    },
});
</script>

<template>
    <div v-if="links.length > 3" class="float-right">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(page, key) in links" :key="key">
                <div
                    v-if="page.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="page.label"
                />
                <Link
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500 cursor-pointer block"
                    :class="{ 'bg-blue-700 text-white': page.active }"
                    :href="page.url"
                    v-html="page.label"
                />
            </template>
        </div>
    </div>
</template>
