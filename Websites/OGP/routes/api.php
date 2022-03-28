<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::resource('user', UserController::class);
Route::post("login",[UserController::class,'index']);
Route::post("register",[UserController::class,'store']);
Route::get("user",[UserController::class,'showAll']);
Route::get("user/{id}",[UserController::class,'show']);
Route::put("user/{id}",[UserController::class,'update']);
Route::delete("user/{id}",[UserController::class,'destroy']);
