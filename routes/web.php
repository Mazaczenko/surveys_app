<?php

use App\Http\Controllers\AttemptController;
use App\Http\Controllers\ProgressController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AttemptController::class, 'create'])->name('create');
Route::get('/list', [AttemptController::class, 'index'])->name('list');
Route::match(['get','post'],'/progress/store', [ProgressController::class, 'store'])->name('progress');

