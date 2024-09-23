<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite as FacadesSocialite;

class VKAuthController extends Controller
{
    public function redirectToProvider()
    {
        return FacadesSocialite::driver('vkontakte')->redirect();
    }

    public function handleProviderCallback()
{
    $user = FacadesSocialite::driver('vkontakte')->user();

    // Найдите пользователя в базе данных
    $authUser = User::where('vk_id', $user->getId())->first();

    if ($authUser) {
        // Если пользователь найден, авторизуйте его
        Auth::login($authUser, true);
    } else {
        // Если пользователь не найден, создайте нового
        $authUser = User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'vk_id' => $user->getId(),
            // Добавьте другие поля, если необходимо
        ]);
        Auth::login($authUser, true);
    }

    // Перенаправление пользователя после успешной авторизации
    return redirect()->route('dashboard');
}

}
