<script setup>
import { Head, Link } from '@inertiajs/vue3';
import EducationLayout from '@/Layouts/EducationLayout.vue';

</script>
<template>

    <Head title="RG Education" />
    <EducationLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">IT заметки</h2>
        </template>
        <div class="max-w-7xl text-sm mx-auto sm:px-6 lg:px-8 flex flex-wrap">
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg m-2 border-2 border-gray-200 text-gray-900 p-4">
                <Link href="/education/Solid">
                                    Принципы Solid
                                </Link>
            </div>
        </div>
    </EducationLayout>
</template>