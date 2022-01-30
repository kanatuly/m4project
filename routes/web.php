<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('weather', [App\Http\Controllers\WeatherController::class,'show_forecast']);

Route::get('books', [App\Http\Controllers\BookController::class, 'index']);
Route::get('books/create', [App\Http\Controllers\BookController::class, 'create']);
Route::post('books/create', [App\Http\Controllers\BookController::class, 'store']);
Route::get('books/show/{id}', [App\Http\Controllers\BookController::class, 'show']);
Route::get('books/edit/{id}', [App\Http\Controllers\BookController::class, 'edit']);
Route::put('books/update/{id}', [App\Http\Controllers\BookController::class, 'update']);
Route::get('books/delete/{id}', [App\Http\Controllers\BookController::class, 'destroy']);

Route::get('books/photos/{id}', [App\Http\Controllers\PhotoController::class, 'thumbnail']);
Route::get('books/photos/create/{id}', [App\Http\Controllers\PhotoController::class, 'create']);
Route::post('books/photos/create/{id}', [App\Http\Controllers\PhotoController::class, 'store']);

Route::get('authors', [App\Http\Controllers\AuthorController::class, 'index']);
Route::get('authors/create', [App\Http\Controllers\AuthorController::class, 'create']);
Route::post('authors/create', [App\Http\Controllers\AuthorController::class, 'store']);
Route::get('authors/show/{id}', [App\Http\Controllers\AuthorController::class, 'show']);
Route::get('authors/edit/{id}', [App\Http\Controllers\AuthorController::class, 'edit']);
Route::put('authors/update/{id}', [App\Http\Controllers\AuthorController::class, 'update']);
Route::get('authors/delete/{id}', [App\Http\Controllers\AuthorController::class, 'destroy']);

require __DIR__.'/auth.php';
