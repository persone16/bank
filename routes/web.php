<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/clear/', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:cache');

    return "Cleared!";
});

Auth::routes();


Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']); // TODO check for works

// Страница создания токена
Route::get('dashboard', function () {
    if (Auth::check()) {
        return auth()
            ->user()
            ->createToken('auth_token', ['admin'])
            ->plainTextToken;
    }

    return redirect("/");
})->middleware('auth');

Route::get('clear/token', function () {
    if(Auth::check()) {
        Auth::user()->tokens()->delete();
    }
    return 'Token Cleared';
})->middleware('auth');
