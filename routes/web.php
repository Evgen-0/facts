<?php

use App\Http\Controllers\FactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Models\Fact;
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

Route::get('/', function () {
    $facts = Fact::paginate();

    return Inertia::render('Home', compact('facts'));
})->name('home');

Route::get('top', function () {
    $facts = Fact::paginate();

    return Inertia::render('Top', compact('facts'));
})->name('top');

Route::get('search', [SearchController::class, 'search'])->name('search');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/fact/{fact}/favorite', [FactController::class, 'favorite'])->name('fact.favorite');
    Route::post('/fact/{fact}/like', [FactController::class, 'like'])->name('fact.like');
    Route::post('/fact/{fact}/dislike', [FactController::class, 'dislike'])->name('fact.dislike');
});

require __DIR__ . '/auth.php';
