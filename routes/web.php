<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [AppController::class, 'index'])->name('home');
Route::get('/location', [AppController::class, 'location'])->name('location');
Route::post('/search', [AppController::class, 'search'])->name('search');
Route::get('/account/{username}', [AppController::class, 'account'])->name('account');

Route::prefix('posts')->group(function () {
    Route::post('/', [PostController::class, 'create'])->name('add');
    Route::post('/update', [PostController::class, 'update'])->name('update');
});

Route::prefix('post')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('post');
    Route::get('/{id}', [PostController::class, 'edit'])->name('edit');
    Route::delete('/del', [PostController::class, 'destroy'])->name('hapus');
});

Route::middleware('auth')->group(function () {
    Route::get('upost/', [AppController::class, 'profilePost'])->name('prfilePost');
    Route::get('/profile', [AppController::class, 'profile'])->name('profile');
});

require __DIR__ . '/auth.php';
