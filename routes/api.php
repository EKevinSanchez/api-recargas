<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post(uri: '/balance',action: [BalanceController::class, 'show']);

Route::post(uri: '/deposit',action: [EventController::class, 'deposit']);

Route::post(uri: '/create-account',action: [EventController::class, 'crearUsuario']);

Route::post(uri: '/recarga', action: [EventController::class, 'recarga'])->name('recarga');



