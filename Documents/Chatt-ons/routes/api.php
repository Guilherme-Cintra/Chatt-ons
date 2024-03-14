<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware'=>'auth:sanctum'], function () {
// Create a chat
    Route::post('/chat',[ChatController::class, 'create']); 
// Get all chats
    Route::get('/chat',[ChatController::class, 'index']); 
// Send message
    Route::post('/chat/{id}/send',[ChatController::class, 'sendMessage']); 
// Get a message from a chat
    Route::get('/chat/{id}/messages',[ChatController::class, 'getMessages']); 
});

