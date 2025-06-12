<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\GoogleAdsDataController;
use App\Http\Controllers\SendApiController;
use App\Http\Controllers\UploadedController;
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
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/todo', function () {
    return Inertia::render('Todo');
})->name('todo');

// タスク一覧（React の `Todo.jsx` にデータを渡す）
Route::get('/todo', [TaskController::class, 'index'])->name('todo');

// タスクを追加（フォームからのPOSTリクエスト）
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

// タスク編集
Route::post('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

// タスクを削除（DELETEリクエスト）
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// タスクの完了・未完了を更新
Route::post('/tasks/{task}/toggle', [TaskController::class, 'toggleComplete'])->name('tasks.toggle');

// Google Ads Data画面
Route::get('/data', [GoogleAdsDataController::class, 'index'])->name('data');

Route::post('/data/add', [GoogleAdsDataController::class, 'store'])->name('data.store');

Route::delete('/data/{id}', [GoogleAdsDataController::class, 'destroy'])->name('data.destroy');

// Uploaded
Route::get('/uploaded', [UploadedController::class, 'index'])->name('uploaded');

// API送信画面
Route::post('/sendApi/upload', [SendApiController::class, 'upload'])->name('sendApi.upload');

Route::post('/sendApi/adjustment', [SendApiController::class, 'adjustment'])->name('sendApi.adjustment');

Route::post('/sendApi/offlineConversionUploaded', [SendApiController::class, 'offlineConversionUploaded'])->name('sendApi.offlineConversionUploaded');

Route::post('/sendApi/actions', [SendApiController::class, 'listConversionActions'])->name('data.actions');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
