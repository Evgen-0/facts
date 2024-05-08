<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [FactController::class, 'indexWeb'])->name('home');

Route::get('top', [FactController::class, 'top'])->name('top');

Route::get('/categories', [CategoryController::class, 'indexWeb'])->name('categories');

Route::get('/tags', [TagController::class, 'index'])->name('tags');

Route::get('search', [SearchController::class, 'search'])->name('search');

Route::get('users/{user:slug}', [UserController::class, 'showWeb'])->name('users.show');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/facts/{fact:slug}', [FactController::class, 'show'])->name('facts.show');

Route::get('/categories/{category:slug}', [CategoryController::class, 'showWeb'])->name('categories.show');

Route::get('/tags/{tag:slug}', [TagController::class, 'show'])->name('tags.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/fact/{fact}/favorite', [FactController::class, 'favorite'])->name('fact.favorite');
    Route::post('/fact/{fact}/like', [FactController::class, 'like'])->name('fact.like');
    Route::post('/fact/{fact}/dislike', [FactController::class, 'dislike'])->name('fact.dislike');

    Route::post('/facts/{fact}/comment', [FactController::class, 'comment'])->name('facts.comment');
});

require __DIR__ . '/auth.php';
