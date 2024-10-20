<script setup>
import { Head, Link } from '@inertiajs/vue3';
import EducationLayout from '@/Layouts/EducationLayout.vue';

</script>
<template>

    <Head title="RG Education" />
    <EducationLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Принципы Solid</h2>
            <Link :href="route('education')" class="bg-gray-400 text-white px-3 rounded-md">Вернуться</Link>
        </template>
        <div class="max-w-7xl text-sm mx-auto sm:px-6 lg:px-8 flex flex-wrap">
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-lg m-2 border-2 border-gray-200 text-gray-900 p-4">
                <p class="text-justify">
                    Предположим, у нас есть класс <b>User</b>, который отвечает как за обработку данных пользователя, так и за
                    отправку
                    подтверждений по электронной почте. Это нарушает принцип единственной ответственности.</p>
                <pre class="text-xs text-wrap mt-2 rounded-sm">
                    <code class="language-php">class User 
{
  private $name;
  private $email;
  public function __construct($name, $email) 
  {
    $this->name = $name;
    $this->email = $email;
  }
  public function register() 
  {
    // Логика регистрации пользователя
    $this->sendConfirmationEmail();
  }
  private function sendConfirmationEmail() 
  {
    // Логика отправки письма
    echo "Отправлено письмо подтверждения на " . $this->email;
  }
}</code></pre>
<p class="mt-4 text-justify">В этом примере класс <b>User</b> имеет две ответственности: управление данными пользователя и отправка электронных писем. Это может привести к проблемам, если мы решим изменить способ отправки письма или изменим логику работы с пользователем.

Чтобы исправить это, мы можем выделить отправку email в отдельный класс:</p>
<pre class="text-xs text-wrap mt-2 rounded-sm">
    <code class="language-php">class User 
{
    private $name;
    private $email;

    public function __construct($name, $email) 
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function register() 
    {
        // Логика регистрации пользователя
    }
}

class EmailService 
{
    public function sendConfirmationEmail($email) 
    {
        // Логика отправки письма
        echo "Отправлено письмо подтверждения на " . $email;
    }
}

// Использование классов
$user = new User("Иван", "ivan@example.com");
$emailService = new EmailService();

$user->register();
$emailService->sendConfirmationEmail($user->getEmail());</code></pre>
<p class="mt-4 text-justify">Теперь класс <b>User</b> отвечает только за управление данными пользователя, а класс  <b>EmailService</b> отвечает за отправку электронных писем. Это соответствует принципу единственной ответственности и упрощает поддержку и тестирование кода.</p>
            </div>
        </div>
    </EducationLayout>
</template>