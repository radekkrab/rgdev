<script setup>
import { ref, onMounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import hljs from 'highlight.js';
import 'highlight.js/styles/devibeans.css';

const showingNavigationDropdown = ref(false);

const isDarkMode = ref(false);

const toggleTheme = () => {
    isDarkMode.value = !isDarkMode.value;
    localStorage.theme = isDarkMode.value ? 'dark' : 'light';
    document.documentElement.classList.toggle('dark', isDarkMode.value);
};

onMounted(() => {
    document.querySelectorAll('pre code').forEach((block) => {
        hljs.highlightElement(block);
    });
    isDarkMode.value = localStorage.theme === 'dark';
    document.documentElement.classList.toggle('dark', isDarkMode.value);
});
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-black">
            <nav class="bg-white border-b border-gray-100 dark:border-gray-500">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 dark:bg-black">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('welcome')">
                                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('welcome')" :active="route().current('welcome')">
                                    На главную
                                </NavLink>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden dark:bg-black">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('welcome')" :active="route().current('welcome')"
                            class="dark:text-white">
                            На главную
                        </ResponsiveNavLink>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white dark:bg-black dark:text-white shadow" v-if="$slots.header">
                <div
                    class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8  border-b border-gray-100 dark:border-gray-500 flex items-center gap-2">
                    <slot name="header" />
                    <div
                        class="flex items-center justify-center  transition-colors duration-300">
                        <button @click="toggleTheme"
                            class="flex items-center p-2 bg-gray-100 dark:bg-gray-700 rounded-full shadow-md transition-all duration-300">
                            <span class="mr-2 text-gray-800 dark:text-gray-200">Тёмный режим</span>
                            <div class="relative">
                                <input type="checkbox" id="theme-toggle" class="hidden" />
                                <div class="w-10 h-5 bg-gray-400 rounded-full shadow-inner transition-all duration-300">
                                </div>
                                <div class="absolute inset-0 w-5 h-5 bg-white rounded-full shadow transition-transform duration-300"
                                    :class="{ 'translate-x-5': isDarkMode, 'translate-x-0': !isDarkMode }"></div>
                            </div>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
