<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\VKAuthController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
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

Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::middleware(['auth'])->group(function () {
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/payment/create', [PaymentController::class, 'createPayment'])->name('payment.create');
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::get('/download/{product}', [DownloadController::class, 'download'])->name('download');
});

Route::post('/payment/webhook', [PaymentController::class, 'callback'])
    ->name('payment.webhook')
    ->withoutMiddleware(['csrf']);

require __DIR__.'/auth.php';
