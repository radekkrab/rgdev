<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const isOpen = ref(false);
const show = ref(false);

const toggleMenu = () => {
    isOpen.value = !isOpen.value;
};

const closeMenu = () => {
    isOpen.value = false;
};
</script>

<template>
    <div class="border-2 rounded-md">
        <div @click="toggleMenu"
            class="nav-icon group lg:hidden ml-auto space-y-2 border-white p-3 min-h-12 relative z-20">
            <div class="w-8 h-0.5 bg-white transition-transform ease-in-out" :class="{ 'hidden': isOpen }"></div>
            <div class="w-8 h-0.5 bg-white transition-transform ease-in-out" :class="{ 'rotate-45': isOpen }"></div>
            <div class="w-8 h-0.5 bg-white transition-transform ease-in-out"
                :class="{ '-translate-y-[10px]': isOpen, '-rotate-45': isOpen }"></div>
        </div>
        <Transition>
            <ul v-if="isOpen"
                class="pointer-events-auto bg-black/80 text-center text-white text-2xl flex flex-col gap-4 items-center font-medium fixed z-10 inset-x-0 inset-y-0 w-full h-full pt-40">
                <li @click="closeMenu">
                    <Link :href="'/rg/login'"
                        class="inline-flex text-white bg-white bg-opacity-5 backdrop-blur-sm shadow-md py-2 w-72 justify-center focus:outline-none hover:bg-black rounded"
                        style="box-shadow: 0 0 3px 2px #0ea5e9;">
                    Войти
                    </Link>
                </li>
                <li @click="closeMenu">
                    <Link :href="route('register')"
                        class="inline-flex text-white bg-white bg-opacity-5 backdrop-blur-sm shadow-md  py-2 w-72 justify-center focus:outline-none hover:bg-black rounded"
                        style="box-shadow: 0 0 3px 2px #0ea5e9;">
                    Зарегистрироваться
                    </Link>
                </li>
                <li @click="closeMenu">
                    <Link :href="`/topics`"
                        class="inline-flex text-white bg-white bg-opacity-5 backdrop-blur-sm shadow-md py-2 w-72 justify-center focus:outline-none hover:bg-black rounded"
                        style="box-shadow: 0 0 3px 2px #0ea5e9;">
                    IT заметки
                    </Link>
                </li>
            </ul>
        </Transition>
    </div>
</template>

<style scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
