<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MenuBurger from '@/Components/MenuBurger.vue';
import Soglasie from '@/Components/Soglasie.vue';
import Politica from '@/Components/Politica.vue';
import FeedbackForm from '@/Components/FeedbackForm.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>

    <Head title="RG Development" />

    <div class="h-full bg-cover bg-center"
        style="background-image: url('storage/img/welcome-bg.jpg'); background-attachment: fixed;">
        <div class="container w-11/12 mx-auto min-h-screen flex  items-center justify-center">
            <div class="lg:max-w-6xl">
                <div class="flex justify-stretch mx-auto pt-4 items-center gap-2">
                    <ApplicationLogo />
                    <div class="bg-white hidden sm:block bg-opacity-5 backdrop-blur-sm rounded-lg px-2 pt-2 hover:bg-black"
                        style="box-shadow: 0 0 3px 2px #0ea5e9;">
                        <h1 class="title-font lg:font-bold text-lg mb-2 text-white"
                            style="text-shadow: 2px 2px 20px #0ea5e9;">
                            RG Development
                        </h1>
                    </div>
                    <nav v-if="canLogin" class="hidden flex-1 justify-end lg:flex">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] border-2 border-sky-700"
                            style="box-shadow: 0 0 3px 2px #0ea5e9;">
                        Dashboard
                        </Link>

                        <template v-else>

                            <Link :href="route('login')"
                                class="inline-flex text-white bg-white bg-opacity-5 backdrop-blur-sm shadow-md py-2 px-3 focus:outline-none hover:bg-black rounded text-sm"
                                style="box-shadow: 0 0 3px 2px #0ea5e9;">
                            Войти
                            </Link>

                            <Link v-if="canRegister" :href="route('register')"
                                class="ml-2 inline-flex text-white bg-white bg-opacity-5 backdrop-blur-sm shadow-md  py-2 px-3 focus:outline-none hover:bg-black rounded text-sm"
                                style="box-shadow: 0 0 3px 2px #0ea5e9;">
                            Зарегистрироваться
                            </Link>
                        </template>
                    </nav>
                    <MenuBurger class="ml-auto" />
                </div>
                <main>
                    <section class="text-white body-font">
                        <div class="container mx-auto flex gap-6 pt-7 lg:py-12 lg:flex-row flex-col items-center">
                            <div class="lg:max-w-xl w-full">
                                <img class="object-cover w-full h-full rounded-xl" alt="hero"
                                    src="storage/img/welcome.png">
                            </div>
                            <div class="bg-white bg-opacity-5 backdrop-blur-sm lg:flex-grow py-2 px-2 lg:pl-14 lg:pr-4 md:pl-16 flex flex-col lg:items-start md:text-left items-center text-center rounded-xl"
                                style="box-shadow: 0 0 3px 2px #0ea5e9;">
                                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-white">Предоставляем<br
                                        class="hidden lg:inline-block">
                                    следующие IT услуги
                                </h1>
                                <p class="mb-3 leading-relaxed">Создание и поддержка веб-сайтов и веб-приложений.</p>
                                <p class="mb-3 leading-relaxed">Уроки по востребованным дисциплинам в области IT,
                                    включая
                                    программирование, базы данных, кибербезопасность. </p>
                                <p class="mb-3 leading-relaxed">Консультации и поддержка: пользователи могут получить
                                    помощь по вопросам
                                    настройки оборудования, программного обеспечения и других IT-проблем.</p>
                                <div>
                                    <FeedbackForm />
                                </div>
                            </div>
                        </div>
                    </section>
                </main>

                <footer>
                    <!-- Футер -->
                    <div class="container px-4 py-8 lg:pt-8 mx-auto lg:max-w-6xl">
                        <div class="grid gap-10 row-gap-6 lg:mb-6 justify-items-center sm:grid-cols-2 lg:grid-cols-4">
                            <div class="lg:text-left text-center">
                                <a href="/" aria-label="Go home" title="Company" class="inline-flex items-center">
                                    <span class="text-xl font-bold tracking-wide leading-5 text-white">RG
                                        Development</span>
                                </a>
                                <div class="mt-6 lg:max-w-sm">
                                    <p class="text-sm text-white">
                                        Создание и развитие сайтов, веб-приложений. Консультирование в сфере IT.
                                        Обучение в сфере IT.
                                    </p>
                                    <p class="mt-4 text-sm text-white">
                                        Сильнее случая, выше обстоятельств.
                                    </p>
                                </div>
                            </div>
                            <div class="text-center justify-self-center">
                                <p class="font-semibold md:mr-5 sm:tracking-wide text-white">Меню</p>
                                <ul class="mt-1 text-white">
                                    <li><a class="md:mr-5 hover:text-sky-500" href="#prices">Войти</a></li>
                                    <li><a class="md:mr-5 hover:text-sky-500" href="#contacts">Зарегистрироваться</a>
                                    </li>
                                    <li><a class="md:mr-5 hover:text-sky-500" href="#getsite">Бесплатная
                                            консультация</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="space-y-2 text-center text-sm">
                                <p class="text-base font-bold tracking-wide text-white">Контакты</p>
                                <div class="flex">
                                    <p class="md:mr-1 text-white">Телефон:</p>
                                    <a href="tel:89195365056" aria-label="Our phone" title="Our phone"
                                        class="transition-colors duration-300 text-white hover:text-sky-500">89195365056</a>
                                </div>
                                <div class="flex">
                                    <p class="md:mr-1 text-white">Email:</p>
                                    <a href="mailto:radxxx7@mail.ru" aria-label="Our email" title="Our email"
                                        class="transition-colors duration-300 text-white hover:text-sky-500">radxxx7@mail.ru</a>
                                </div>
                                <div class="flex">
                                    <p class="md:mr-1 text-white">Адрес:</p>
                                    <a href="https://www.google.com/maps" target="_blank" rel="noopener noreferrer"
                                        aria-label="Our address" title="Our address"
                                        class="transition-colors duration-300 text-white hover:text-sky-500">
                                        Нижневартовск
                                    </a>
                                </div>
                            </div>
                            <div class="text-center">
                                <span class="text-base font-bold tracking-wide text-white">Социальные сети</span>
                                <div class="flex items-center justify-center mt-3 space-x-3">
                                    <a class="text-white transition-colors duration-300 transform hover:text-green-500"
                                        href="https://wa.me/79195365056">
                                        <svg class="w-8 h-8" id="Capa_1" style="enable-background:new 0 0 58 58;"
                                            version="1.1" viewBox="0 0 58 58" xml:space="preserve"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <g>
                                                <path
                                                    d="M0,58l4.988-14.963C2.457,38.78,1,33.812,1,28.5C1,12.76,13.76,0,29.5,0S58,12.76,58,28.5   S45.24,57,29.5,57c-4.789,0-9.299-1.187-13.26-3.273L0,58z"
                                                    style="fill:#2CB742;" />
                                                <path
                                                    d="M47.683,37.985c-1.316-2.487-6.169-5.331-6.169-5.331c-1.098-0.626-2.423-0.696-3.049,0.42   c0,0-1.577,1.891-1.978,2.163c-1.832,1.241-3.529,1.193-5.242-0.52l-3.981-3.981l-3.981-3.981c-1.713-1.713-1.761-3.41-0.52-5.242   c0.272-0.401,2.163-1.978,2.163-1.978c1.116-0.627,1.046-1.951,0.42-3.049c0,0-2.844-4.853-5.331-6.169   c-1.058-0.56-2.357-0.364-3.203,0.482l-1.758,1.758c-5.577,5.577-2.831,11.873,2.746,17.45l5.097,5.097l5.097,5.097   c5.577,5.577,11.873,8.323,17.45,2.746l1.758-1.758C48.048,40.341,48.243,39.042,47.683,37.985z"
                                                    style="fill:#FFFFFF;" />
                                            </g>
                                            <g />
                                            <g />
                                            <g />
                                            <g />
                                            <g />
                                            <g />
                                            <g />
                                            <g />
                                            <g />
                                            <g />
                                            <g />
                                            <g />
                                            <g />
                                            <g />
                                            <g />
                                        </svg>
                                    </a>

                                    <a class=" text-white transition-colors duration-300 transform hover:text-blue-500"
                                        href="https://vk.com/radevc">
                                        <svg width="34" height="34" viewBox="0 0 48 48" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0 23.04C0 12.1788 0 6.74826 3.37413 3.37413C6.74826 0 12.1788 0 23.04 0H24.96C35.8212 0 41.2517 0 44.6259 3.37413C48 6.74826 48 12.1788 48 23.04V24.96C48 35.8212 48 41.2517 44.6259 44.6259C41.2517 48 35.8212 48 24.96 48H23.04C12.1788 48 6.74826 48 3.37413 44.6259C0 41.2517 0 35.8212 0 24.96V23.04Z"
                                                fill="#0077FF" />
                                            <path
                                                d="M25.54 34.5801C14.6 34.5801 8.3601 27.0801 8.1001 14.6001H13.5801C13.7601 23.7601 17.8 27.6401 21 28.4401V14.6001H26.1602V22.5001C29.3202 22.1601 32.6398 18.5601 33.7598 14.6001H38.9199C38.0599 19.4801 34.4599 23.0801 31.8999 24.5601C34.4599 25.7601 38.5601 28.9001 40.1201 34.5801H34.4399C33.2199 30.7801 30.1802 27.8401 26.1602 27.4401V34.5801H25.54Z"
                                                fill="white" />
                                        </svg>

                                    </a>

                                    <a class=" text-white transition-colors duration-300 transform hover:text-blue-500"
                                        href="https://t.me/loki777i">
                                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" aria-label="Telegram"
                                            role="img" viewBox="0 0 512 512">
                                            <rect width="512" height="512" rx="15%" fill="#37aee2" />
                                            <path fill="#c8daea" d="M199 404c-11 0-10-4-13-14l-32-105 245-144" />
                                            <path fill="#a9c9dd" d="M199 404c7 0 11-4 16-8l45-43-56-34" />
                                            <path fill="#f6fbfe"
                                                d="M204 319l135 99c14 9 26 4 30-14l55-258c5-22-9-32-24-25L79 245c-21 8-21 21-4 26l83 26 190-121c9-5 17-3 11 4" />
                                        </svg>
                                    </a>
                                </div>
                                <p class="mt-4 text-sm text-white">
                                    Спасибо, что вы здесь, и помните: ваш потенциал безграничен.
                                </p>
                            </div>
                        </div>
                        <div
                            class="flex flex-col-reverse justify-between items-center md:items-center pt-4 mt-4 lg:pb-5 border-t lg:flex-row">
                            <p class="text-sm text-white text-center md:text-center">
                                © Copyright 2024 RG Inc. All rights reserved.
                            </p>
                            <ul
                                class="flex flex-col mb-3 space-y-2 lg:mb-0 sm:space-y-0 sm:space-x-5 sm:flex-row md:self-center text-center">
                                <li>
                                    <span class="cursor-pointer font-semibold text-blue-500">
                                        <Politica />
                                    </span>
                                </li>
                                <li>
                                    <span class="cursor-pointer font-semibold text-blue-500">
                                        <Soglasie />
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

</template>
