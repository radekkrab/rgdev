<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import Soglasie from '@/Components/Soglasie.vue';
import Politica from '@/Components/Politica.vue';

const showModal = ref(false);
const modalMessage = ref('');
const captchaReady = ref(false);

const form = useForm({
    name: '',
    phone: '',
    message: '',
    policy: false,
    token: '',
});

// Инициализация капчи при открытии модального окна
const initializeCaptcha = () => {
    if (document.getElementById('yandex-captcha-script') || !showModal.value) return;

    const script = document.createElement('script');
    script.id = 'yandex-captcha-script';
    script.src = 'https://smartcaptcha.yandexcloud.net/captcha.js';
    script.async = true;
    script.defer = true;

    script.onload = () => {
        if (!window.smartCaptcha) {
            modalMessage.value = 'Ошибка загрузки защиты от роботов';
            return;
        }

        window.smartCaptcha.render('captcha-container', {
            sitekey: 'ysc1_hBWstkOuWJkV2PhLP3p4Y6c4Yg9PJh2KOsclXACWc0871987',
            invisible: true,
            callback: (token) => {
                form.token = token;
                submitForm();
            },
        });
        captchaReady.value = true;
    };

    script.onerror = () => {
        modalMessage.value = 'Ошибка загрузки защиты. Пожалуйста, обновите страницу.';
    };

    document.head.appendChild(script);
};

const openModal = () => {
    showModal.value = true;
    initializeCaptcha();
};

const closeModal = () => {
    showModal.value = false;
    form.reset();
    form.token = '';
};

const handleSubmit = () => {
    if (!form.policy) {
        modalMessage.value = 'Необходимо согласие на обработку персональных данных';
        return;
    }

    if (!captchaReady.value) {
        modalMessage.value = 'Система защиты ещё не готова. Пожалуйста, подождите.';
        return;
    }

    if (form.token) {
        submitForm();
    } else {
        window.smartCaptcha?.execute();
    }
};

const submitForm = () => {
    form.processing = true;

    form.post('/send', {
        preserveScroll: true,
        onSuccess: () => {
            modalMessage.value = 'Спасибо за обращение! Мы свяжемся с вами в ближайшее время.';
            form.reset();
            form.token = '';
        },
        onError: (errors) => {
            modalMessage.value = errors.message || 'Произошла ошибка при отправке формы';
            form.token = '';
        },
        onFinish: () => {
            form.processing = false;
        }
    });
};
</script>

<template>
    <button @click="openModal"
            class="inline-flex text-black font-semibold bg-gray-100 border-0 mb-2 py-4 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg">
        Бесплатная консультация
    </button>

    <Modal :show="showModal" @close="closeModal" :max-width="'md'">
        <div class="bg-white text-center text-white font-medium inset-x-0 w-full h-full overflow-auto">
            <form @submit.prevent="handleSubmit">
                <div class="mx-auto bg-white flex flex-col gap-1 w-full h-auto">
                    <p class="leading-tight mt-6 mb-2 text-gray-600 text-3xl mx-4">
                        Опишите вопрос или просто оставьте контакты для связи
                    </p>

                    <!-- Поля формы -->
                    <div class="relative mb-2 mx-4">
                        <label for="name" class="leading-7 text-xl text-gray-600">Как к Вам обращаться?</label>
                        <input type="text" id="name" pattern="[A-Za-zА-Яа-яЁё\s]+"
                               title="Имя должно содержать только буквы и пробелы" placeholder="Имя" required
                               v-model="form.name"
                               class="invalid:border-red-600 w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
                    </div>

                    <div class="relative mb-2 mx-4">
                        <label for="tel" class="leading-7 text-xl text-gray-600">Ваш номер телефона:</label>
                        <input type="tel" id="tel" placeholder="Телефон" pattern="((8\d{10})|(\+7\d{10}))"
                               title="Пожалуйста, введите 11 цифр, начинающихся с 8, или 11 цифр, начинающихся с +7."
                               required v-model="form.phone"
                               class="invalid:border-red-600 w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        <div v-if="form.errors.phone" class="text-red-500 text-sm">{{ form.errors.phone }}</div>
                    </div>

                    <div class="relative mb-2 mx-4">
                        <label for="message" class="leading-7 text-xl text-gray-600">Сообщение:</label>
                        <textarea id="message" pattern="[A-Za-zА-Яа-я0-9,.:]*"
                                  title="Текст должен содержать только буквы, цифры и символы . , :" required
                                  v-model="form.message"
                                  class="invalid:border-red-600 w-full h-24 bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                        </textarea>
                        <div v-if="form.errors.message" class="text-red-500 text-sm">{{ form.errors.message }}</div>
                    </div>

                    <!-- Контейнер для капчи (невидимой) -->
                    <div id="captcha-container" style="display: none;"></div>

                    <!-- Чекбокс согласия -->
                    <div class="flex justify-center gap-1 items-center my-2 mx-4 text-gray-500">
                        <input type="checkbox" id="policy" class="w-8 h-8" required v-model="form.policy">
                        <p class="text-sm text-gray-500 text-justify">Нажимая кнопку «Отправить», я даю свое
                            согласие на
                            обработку моих персональных данных, в соответствии с Федеральным законом от 27.07.2006
                            года
                            №152-ФЗ
                            «О персональных данных» и <span
                                class="cursor-pointer font-semibold text-blue-500">
                                <Soglasie />
                            </span>.
                            Подробнее читайте в <span class="cursor-pointer font-semibold text-blue-500">
                                <Politica class="text-blue-500" />
                            </span>
                        </p>
                    </div>

                    <!-- Кнопка отправки -->
                    <div>
                        <button type="submit" :disabled="form.processing"
                                class="text-white mx-4 mb-4 bg-green-500 border-0 py-2 px-6 mt-2 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                            {{ form.processing ? 'Отправка...' : 'Отправить' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </Modal>

    <!-- Модальное окно для сообщений -->
    <Modal :show="!!modalMessage" @close="modalMessage = ''" :max-width="'md'">
        <div class="flex justify-center items-center w-full h-full bg-gray-700">
            <div class="text-white text-center text-2xl p-4">
                {{ modalMessage }}
            </div>
        </div>
    </Modal>
</template>

