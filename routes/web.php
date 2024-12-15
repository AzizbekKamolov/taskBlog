<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// one million request rate limit can be guard by the web server (nginx or apache)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/articles', [HomeController::class, 'articles'])->name('articles');
Route::get('/articles/{slug}', [HomeController::class, 'article'])->name('article');
Route::post('/articles/{slug}', [HomeController::class, 'comment'])->name('comment');
Route::post('/like', [HomeController::class, 'like'])->name('like');
Route::post('/show', [HomeController::class, 'show'])->name('show');
