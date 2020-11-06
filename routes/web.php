<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

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
    return view('auth.login');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});
//initialize the authentication routes

Auth::routes();

//Get Request's
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard']);
Route::get('/all-books', [HomeController::class, 'allBooks']);
Route::get('/all-archive-books', [HomeController::class, 'allArchiveBooks']);
Route::get('/create-book', [HomeController::class, 'createBook']);
Route::get('/get-book/{id}', [HomeController::class, 'getBookDetails']);
Route::get('/get-archive-book/{id}', [HomeController::class, 'getArchiveBookDetails']);
Route::get('/update-book/{id}', [HomeController::class, 'updateBook']);
Route::get('/archive-book/{id}', [HomeController::class, 'archiveBook']);
Route::get('/restore-book/{id}', [HomeController::class, 'restoreBook']);
Route::get('/delete-book/{id}', [HomeController::class, 'deleteBook']);

//Post Request's
Route::post('/savebook', [HomeController::class, 'saveBook'])->name('saveBook');
Route::post('/updatebook/{id}', [HomeController::class, 'saveUpdateBook'])->name('updateBook');