<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::middleware('auth:sanctum')
    ->group(function () {


        Route::resource('tasks', TaskController::class);

        Route::post('tasks/{task}/move', [TaskController::class, 'move'])
            ->name('tasks.move');

        Route::post('tasks/{task}/archive', [TaskController::class, 'archive'])
            ->name('tasks.archive');
        // 

    });
