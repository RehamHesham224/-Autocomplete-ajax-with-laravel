<?php

use App\Http\Controllers\TextController;
use Illuminate\Support\Facades\Route;


Route::get('/', [TextController::class, 'index'])->name('home');
Route::get('autocomplete', [TextController::class,'autoComplete'])->name('autocomplete');
Route::get('get-data', [TextController::class,'getData'])->name('get-data');
Route::post('store', [TextController::class,'store'])->name('store');
