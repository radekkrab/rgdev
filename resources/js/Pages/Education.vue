<script setup>
import { Head, Link } from '@inertiajs/vue3';
import EducationLayout from '@/Layouts/EducationLayout.vue';

</script>
<template>

    <Head title="RG Education" />
    <EducationLayout>
        <template #header>
            <h2 class="font-semibold text-xl self-center text-gray-800 dark:text-gray-300 leading-tight">IT заметки</h2>
        </template>
        <div class="max-w-7xl text-sm mx-auto sm:px-6 lg:px-8 flex flex-wrap">
            <div
                class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg m-2 border-2 border-gray-200 dark:border-gray-400 text-gray-900 dark:text-gray-200 p-4">
                <Link href="/Solid">
                                    Принципы Solid
                                </Link>
            </div>
        </div>
    </EducationLayout>
</template>