<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\VKAuthController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::post('/send', [MailController::class, 'send']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Маршруты для авторизации через ВКонтакте
Route::get('/auth/vk', [VKAuthController::class, 'redirectToProvider'])->name('vk.auth');
Route::get('/auth/vk/callback', [VKAuthController::class, 'handleProviderCallback']);

Route::get('/topics', [TopicController::class, 'index'])->name('topics');
Route::get('/topics/{topic}', [TopicController::class, 'show']);
Route::get('/articles/{article}', [ArticleController::class, 'show']);

require __DIR__.'/auth.php';
