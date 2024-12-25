<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chat', function () {
    return view('reverb.chatRoom');
});

// Route::post('/chat/room', function () {
//     return view('reverb.chatRoomChatting');
// })->name('chat.room');

Route::post('chat/room', [ChatController::class, 'index'])->name('chat.room');
Route::post('chat/room/send', [ChatController::class, 'send'])->name('chat.room.send');
