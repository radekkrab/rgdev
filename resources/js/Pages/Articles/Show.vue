<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import TopicsLayout from '@/Layouts/TopicsLayout.vue';

const { article } = usePage().props;

</script>
<template>

    <Head title="RG Education" />
    <TopicsLayout>
        <template #header>
            <h2 class="font-semibold text-xl self-center text-gray-800 dark:text-gray-200 leading-tight">{{ article.title }}</h2>
            <Link :href="`/topics/${article.topic_id}`" class="bg-gray-100 dark:bg-gray-700 px-3 py-2 rounded-2xl">Вернуться</Link>
        </template>
        <div class="max-w-7xl text-sm mx-auto sm:px-6 lg:px-8 flex flex-wrap dark:bg-black">
            <div v-html="article.content"
                class="bg-white dark:bg-black dark:text-gray-200 overflow-hidden shadow-sm sm:rounded-lg m-2 border-2 border-gray-200 dark:border-gray-700 text-gray-900 p-4">
                
            </div>
        </div>
    </TopicsLayout>
</template>