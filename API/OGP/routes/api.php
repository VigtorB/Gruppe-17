<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoinController;

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
//User End-points
Route::resource('user', UserController::class);
Route::post("login",[UserController::class,'index']);
Route::post("register",[UserController::class,'store']);
Route::get("user",[UserController::class,'showAll']);
Route::get("user/{id}",[UserController::class,'show']);
Route::put("user/{id}",[UserController::class,'update']);
Route::delete("user/{id}",[UserController::class,'destroy']);
//User End-points

//Coin End-points
Route::get("coins/{id}",[UserController::class,'showCoins']);
Route::post("coins",[UserController::class,'storeCoin']);
Route::put("coins/{id}",[UserController::class,'updateCoin']);
Route::delete("coins/{id}",[UserController::class,'destroyCoin']);
//Coin End-points

