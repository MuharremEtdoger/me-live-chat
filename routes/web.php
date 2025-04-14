<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

// Mesajlaşma routes
Route::middleware('auth')->group(function () {
    Route::get('/api/messages', [MessageController::class, 'index']);
    Route::get('/api/messages/{receiverId}', [MessageController::class, 'getThisMessages']);
    Route::get('/api/users', [MessageController::class, 'listOtherUsers']);
    Route::get('/api/message-lists', [MessageController::class, 'messageLists']);
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
    Route::get('/messages/{userId}', [MessageController::class, 'getMessages'])->name('messages.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
