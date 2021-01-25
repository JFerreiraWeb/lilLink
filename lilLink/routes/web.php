<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UsedShortLinkController;

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

Route::get('/', [\App\Http\Controllers\UsedShortLinkController::class, 'index']);
Route::get('/{short_url}', [\App\Http\Controllers\UsedShortLinkController::class, 'redirect']);
Route::get('/list/update', [\App\Http\Controllers\ShortLinkListController::class, 'getlist']);
Route::post('/shorten', [\App\Http\Controllers\UsedShortLinkController::class, 'shorten']);


Auth::routes();

