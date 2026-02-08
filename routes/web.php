<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::middleware(['auth'])->group(function () {

    // Board
    Route::get('/board', [BoardController::class, 'index'])
        ->name('home.board');
});




Route::middleware(['auth'])
    ->group(function () {


        Route::resource('tasks', TaskController::class)
            ->except(['edit', 'create']);

        Route::post('tasks/{task}/move', [TaskController::class, 'move'])
            ->name('tasks.move');

        Route::post('tasks/{task}/assign', [TaskController::class, 'assignUsers'])
            ->name('tasks.assignUsers');

        Route::post('tasks/{task}/archive', [TaskController::class, 'archive'])
            ->name('tasks.archive');
        // 

    });













require __DIR__ . '/auth.php';

Route::fallback(function () {
    return route('home.board');
});
