<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuoteController;



Route::get('/', [QuoteController::class, 'index'])->name('home');
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::post('/quotes', [QuoteController::class, 'store'])->name('quotes.store');
    Route::put('/quotes/{quote}', [QuoteController::class, 'update'])->name('quotes.update');
    Route::delete('/quotes/{quote}', [QuoteController::class, 'destroy'])->name('quotes.destroy');
    Route::post('/quotes/{quote}/like', [QuoteController::class, 'toggleLike'])->name('quotes.like');
    Route::post('/quotes/{quote}/bookmark', [QuoteController::class, 'toggleBookmark'])->name('quotes.bookmark');
});