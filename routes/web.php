<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/getNormalTransactions', [App\Http\Controllers\PostsController::class, 'getNormalTransactions'])->name('getNormalTransactions');
Route::get('/showNormalTransactions', [App\Http\Controllers\PostsController::class, 'showNormalTransactions'])->name('showNormalTransactions');
Route::get('/getInternalTransactions', [App\Http\Controllers\PostsController::class, 'getInternalTransactions'])->name('getInternalTransactions');
Route::get('/showInternalTransactions', [App\Http\Controllers\PostsController::class, 'showInternalTransactions'])->name('showInternalTransactions');
Route::get('/getTimeTransactions', [App\Http\Controllers\PostsController::class, 'getTimeTransactions'])->name('getTimeTransactions');
Route::get('/showTimeTransactions', [App\Http\Controllers\PostsController::class, 'showTimeTransactions'])->name('showTimeTransactions');
