<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Public routes
Route::get('/posts', [PostController::class, 'getAll']);
Route::get('/post/{id}', [PostController::class, 'get']);
Route::get('/post/{id}/comments', [CommentController::class, 'getByPost']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'user']);

Route::post('/post', [PostController::class, 'create'])->middleware('role:user,editor');
Route::post('/comment', [CommentController::class, 'create'])->middleware('role:user,editor');

Route::put('/post/{id}/like', [PostController::class, 'like'])->middleware('role:user,editor');
Route::put('/post/{id}/unlike', [PostController::class, 'unlike'])->middleware('role:user,editor');

Route::put('/post/{id}', [PostController::class, 'update'])->middleware('can:update,post');
Route::put('/comment/{id}', [CommentController::class, 'update'])->middleware('can:update,comment');

Route::delete('/post/{id}', [PostController::class, 'delete'])->middleware('can:delete,post');
Route::delete('/comment/{id}', [CommentController::class, 'delete'])->middleware('can:delete,comment');

// Для авторизованных пользователей
Route::middleware('auth:sanctum')->group(function () {

});
