<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MarketLayout from '@/Layouts/MarketLayout.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    products: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const formattedProducts = computed(() => {
    return props.products.data.map(product => ({
        ...product,
        formatted_price: new Intl.NumberFormat('ru-RU', {
            style: 'currency',
            currency: 'RUB',
            maximumFractionDigits: 0,
        }).format(product.price),
    }));
});
</script>

<template>
    <MarketLayout>
        <Head title="Каталог PDF-книг" />

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">Каталог PDF-книг</h1>

                <!-- Фильтры (можно добавить позже) -->
                <!-- <div class="mb-6">
                    ...
                </div> -->

                <!-- Список продуктов -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="product in formattedProducts" :key="product.id"
                         class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <Link :href="route('products.show', product.id)">
                            <div class="h-48 overflow-hidden">
                                <img :src="product.cover_image || '/images/default-cover.jpg'"
                                     :alt="product.title"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ product.title }}</h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ product.description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-indigo-600">{{ product.formatted_price }}</span>
                                    <span class="text-sm text-gray-500">{{ product.created_at }}</span>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>

                <!-- Пагинация -->
                <Pagination :links="products.links" class="mt-8" />
            </div>
        </div>
    </MarketLayout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
