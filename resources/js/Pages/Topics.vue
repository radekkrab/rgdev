<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import TopicsLayout from '@/Layouts/TopicsLayout.vue';

const { topics } = usePage().props;


</script>
<template>

    <Head title="RG Education" />
    <TopicsLayout>
        <template #header>
            <h2 class="font-semibold text-xl self-center text-gray-800 dark:text-gray-300 leading-tight">IT заметки</h2>
        </template>
        <div class="max-w-7xl text-sm mx-auto sm:px-6 lg:px-8 flex flex-wrap">
            <div v-for="topic in topics" :key="topic.id"
                class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg m-2 border-2 border-gray-200 dark:border-gray-400 text-gray-900 dark:text-gray-200 p-4">
                <Link :href="`/topics/${topic.id}`">
                    {{ topic.title }}
                                </Link>
            </div>
        </div>
    </TopicsLayout>
</template>