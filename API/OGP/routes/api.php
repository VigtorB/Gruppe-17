<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\FriendController;

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
//Route::resource('user', UserController::class);
Route::post("login",[UserController::class,'index']);
Route::post("register",[UserController::class,'store']);
Route::get("user",[UserController::class,'showAll']);
Route::get("user/{id}",[UserController::class,'getUser']);
//Route::get("user/username/{username}",[UserController::class,'getUserByUsername']);
Route::put("user/{id}",[UserController::class,'update']);
Route::delete("user/{id}",[UserController::class,'destroy']);
//User End-points

//Coin End-points
Route::get("coins/{id}",[CoinController::class,'getCoins']);
Route::post("coins",[CoinController::class,'storeCoin']);
Route::put("coins/{id}",[CoinController::class,'updateCoin']);
Route::delete("coins/{id}",[CoinController::class,'destroyCoin']);
//Coin End-points

//Friend End-points
Route::post("friends",[FriendController::class,'addFriend']);
Route::post("friends",[FriendController::class,'acceptFriend']);
Route::get("friends/{id}",[FriendController::class,'getFriends']);
Route::delete("friends",[FriendController::class,'deleteFriend']);
//Friend End-points
