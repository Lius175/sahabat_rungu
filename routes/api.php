<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\UserLearningController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AnswerController;


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

Route::get('/quiz/{id}', [QuizController::class, 'show']);
Route::get('/answers/{id}', [AnswerController::class, 'show']);
Route::post('/answers/level1', [AnswerController::class, 'storeLevel1']);
Route::post('/answers/level2', [AnswerController::class, 'storeLevel2']);
Route::post('/answers/level3', [AnswerController::class, 'storeLevel3']);

