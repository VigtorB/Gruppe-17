<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\BlackjackController;

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
Route::get("user/{info}",[UserController::class,'getUser']);
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
Route::get("friends/addfriend/{id}/{friend_id}",[FriendController::class,'addFriend']);

Route::get("friends/isfriend/{id}/{friend_id}",[FriendController::class,'isFriend']);
Route::get("friends/getfriends/{id}",[FriendController::class,'getFriends']);
Route::get("friends/getOtherUser/{id}/{username}",[FriendController::class,'getOtherUser']);
Route::get("friends/deletefriend/{id}/{friend_id}",[FriendController::class,'deleteFriend']);
//Friend End-points

//Games End-points
Route::post("blackjack",[BlackjackController::class,'startBlackjack']);
Route::get("blackjack/{id}/hit",[BlackjackController::class,'hit']);
Route::get("blackjack/{id}/stand",[BlackjackController::class,'stand']);
//Games End-points
