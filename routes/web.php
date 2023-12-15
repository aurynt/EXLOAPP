<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AppController;
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

Route::get('/', [AppController::class, 'index']);
Route::get('/location', [AppController::class, 'location'])->name('location');
Route::post('/search', [AppController::class, 'search'])->name('search');
Route::get('/account/{username}', [AppController::class, 'account'])->name('account');
Route::get('/profile/{username}', [AppController::class, 'profile'])->name('profile');

Route::prefix('posts')->group(function () {
    Route::post('/', [PostController::class, 'create'])->name('add');
    Route::put('/update', [PostController::class, 'update'])->name('update');
});

Route::prefix('post')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('post');
    Route::get('/{id}', [PostController::class, 'edit'])->name('edit');
    Route::delete('/del', [PostController::class, 'destroy']);
});
