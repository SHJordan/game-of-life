<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameOfLifeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/game-of-life', [GameOfLifeController::class, 'index']);
Route::put('/game-of-life/{gameBoard}', [GameOfLifeController::class, 'update'])->name('game-of-life.update');
