<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function() {
    // вывести текущего пользователя
    Route::get('user', function(Request $request) {
        return $request->user();
    });

    // список всех пользователей
    Route::get('users', [UserController::class, 'users']);

    // список всех транзакций
    Route::get('transactions', [TransactionController::class, 'transaction']);

    // получить сообщение
    Route::get('transactions/{id}', [TransactionController::class, 'singleTransaction']);

    // пополнения баланса
    Route::post('transactions/replenish', [TransactionController::class, 'replenishTransaction']);

    // перевод средств между пользователями
    Route::post('transactions/money-transaction', [TransactionController::class, 'moneyTransaction']);
});