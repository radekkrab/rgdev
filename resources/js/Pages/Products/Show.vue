<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    product: Object,
});

const form = useForm({});

const buyProduct = () => {
    form.post(route('payment.create'), {
        product_id: props.product.id,
        amount: props.product.price,
    }, {
        onSuccess: (response) => {
            window.location.href = response.props.confirmation_url;
        }
    });
};
</script>

<template>
    <div class="max-w-4xl mx-auto py-12">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="md:flex">
                <div class="md:flex-shrink-0">
                    <img class="h-48 w-full object-cover md:w-48" :src="product.cover_image" alt="Обложка">
                </div>
                <div class="p-8">
                    <h1 class="text-2xl font-bold text-gray-800">{{ product.title }}</h1>
                    <p class="mt-2 text-gray-600">{{ product.description }}</p>
                    <div class="mt-4">
                        <span class="text-xl font-bold text-gray-900">{{ product.price }} ₽</span>
                    </div>
                    <button @click="buyProduct"
                            class="mt-6 px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700">
                        Купить PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
