<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameOfLifeController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [GameOfLifeController::class, 'index'])->name('game-of-life.index');
Route::put('/{gameBoard}', [GameOfLifeController::class, 'update'])->name('game-of-life.update');
