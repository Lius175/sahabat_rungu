<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\UserLearningController;
use App\Http\Controllers\ForumController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('/user/update', [AuthController::class, 'update']);
Route::get('learnings/{id}', [LearningController::class, 'show']);
Route::post('user-learning/completed', [UserLearningController::class, 'markAsCompleted']);
Route::get('user-learning/progress/{user_id}', [UserLearningController::class, 'getProgress']);



Route::post('/forum/post', [ForumController::class, 'store'])->name('forum.store');
Route::get('/all-forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.show');
Route::post('/reply', [ForumController::class, 'storeReply']);
