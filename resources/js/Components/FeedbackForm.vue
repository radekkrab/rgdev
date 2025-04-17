<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';

const showModal = ref(false);
const modal2Message = ref('');
const token = ref('');

const form = useForm({
    name: null,
    phone: null,
    message: null,
    policy: false,
    token: token.value,
    processing: false,
    progress: null,
});

function openModal() {
    showModal.value = true;
    loadCaptcha();
}

function closeModal() {
    showModal.value = false;
    token.value = ''; // Сбрасываем токен при закрытии модального окна
}

function loadCaptcha() {
    const script = document.createElement('script');
    script.src = 'https://smartcaptcha.yandexcloud.net/captcha.js?render=onload&onload=onloadFunction';
    script.defer = true;
    document.head.appendChild(script);
}

function onloadFunction() {
    console.log('Капча загружена'); // Для отладки

    if (!window.smartCaptcha) {
        console.error('SmartCaptcha не загружен'); // Для отладки
        return;
        }

    window.smartCaptcha.render('captcha-container', {
                sitekey: 'ysc1_hBWstkOuWJkV2PhLP3p4Y6c4Yg9PJh2KOsclXACWc0871987',
                invisible: true,
                callback: callback,
            });
}

function callback(captchaToken) {
    console.log('Капча пройдена, токен:', captchaToken); // Для отладки
    token.value = captchaToken; // Сохраняем токен капчи
    submit(); // Вызываем отправку формы после успешного прохождения капчи
}

function handleSubmit() {
    console.log('handleSubmit вызван'); // Для отладки
    if (!token.value) {
        modal2Message.value = 'Пожалуйста, пройдите капчу.';
        showModal.value = true;
        return;
    }

    if (!window.smartCaptcha) {
        console.error('SmartCaptcha не доступен');
        return;
    }

    console.log('Запуск капчи');
    window.smartCaptcha.execute();
}

function submit() {
    console.log('Отправка формы');
    form.processing = true;
    form.progress = { percentage: 0 };

    const interval = setInterval(() => {
        if (form.progress.percentage < 100) {
            form.progress.percentage += 10;
        } else {
            clearInterval(interval);
            form.processing = false;
            form.progress = null;
        }
    }, 500);

    form.post('/send', {
        onSuccess: () => {
            form.reset();
            showModal.value = false;
            modal2Message.value = 'Спасибо за обращение! Мы свяжемся с вами в ближайшее время.';
            showModal.value = true;
        },
        onError: (error) => {
            form.reset();
            showModal.value = false;
            modal2Message.value = 'Ошибка отправки формы: ' + error.message;
            showModal.value = true;
        }
    });
}

</script>

<template>
    <button @click="openModal"
        class="inline-flex text-black font-semibold bg-gray-100 border-0 mb-2 py-4 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg">Бесплатная
        консультация</button>
    <Modal v-if="showModal" :show="showModal" @close="closeModal" :max-width="'md'">
        <div id="form" class="bg-white text-center text-white font-medium inset-x-0 w-full h-full overflow-auto">
            <form @submit.prevent="handleSubmit">
                <div class="mx-auto bg-white flex flex-col gap-1 w-full h-auto">
                    <p class="leading-tight mt-6 mb-2 text-gray-600 text-3xl mx-4">Опишите вопрос или просто
                        оставьте контакты для связи</p>
                    <div class="relative mb-2 mx-4">
                        <label for="name" class="leading-7 text-xl text-gray-600">Как к Вам обращаться?</label>
                        <input type="text" id="name" pattern="[A-Za-zА-Яа-яЁё\s]+"
                            title="Имя должно содержать только буквы и пробелы" placeholder="Имя" required
                            v-model="form.name"
                            class="invalid:border-red-600 w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        <div v-if="form.errors.name">{{ form.errors.name }}</div>
                    </div>
                    <div class="relative mb-2 mx-4">
                        <label for="tel" class="leading-7 text-xl text-gray-600">Ваш номер телефона:</label>
                        <input type="tel" id="tel" placeholder="Телефон" pattern="((8\d{10})|(\+7\d{10}))"
                            title="Пожалуйста, введите 11 цифр, начинающихся с 8, или 11 цифр, начинающихся с +7."
                            required v-model="form.phone"
                            class="invalid:border-red-600 w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        <div v-if="form.errors.phone">{{ form.errors.phone }}</div>
                    </div>
                    <div class="relative mb-2 mx-4">
                        <label for="message" class="leading-7 text-xl text-gray-600">Сообщение:</label>
                        <textarea id="message" pattern="[A-Za-zА-Яа-я0-9,.:]*"
                            title="Текст должен содержать только буквы, цифры и символы . , :" required
                            v-model="form.message"
                            class="invalid:border-red-600 w-full h-24 bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                            </textarea>
                        <div v-if="form.errors.message">{{ form.errors.message }}</div>
                    </div>
                    <div id="captcha-container"></div>
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
                    <div><input id="submit" type="submit" :disabled="form.processing"
                            class="text-white mx-4 mb-4 bg-green-500 border-0 py-2 px-6 mt-2 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                            :value="form.progress ? form.progress.percentage + '%' : 'Отправить'"></input>
                    </div>
                </div>
            </form>
        </div>
    </Modal>
    <Modal v-if="showModal2" :show="showModal2" @close="showModal2 = false" :max-width="'md'">
        <div class="flex justify-center items-center w-full h-full bg-gray-700">
            <div class="text-white text-center text-2xl p-4">
                {{ modal2Message }}
            </div>
        </div>
    </Modal>

</template>
