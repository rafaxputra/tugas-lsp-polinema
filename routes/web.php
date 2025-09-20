<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\LetterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AboutController;

Route::get('/', [LetterController::class, 'index'])->name('letters.index');
Route::resource('letters', LetterController::class)->except(['index']);
Route::get('letters/{letter}/download', [LetterController::class, 'download'])->name('letters.download');

Route::resource('categories', CategoryController::class);

Route::get('about', [AboutController::class, 'index'])->name('about');
