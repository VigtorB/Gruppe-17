<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\CoinController; //TODO: Denne skal vi sætte ind, for at bruge den i post metoder.
use App\Http\Controllers\GamesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Verify;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

/*{{  }}
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Home pages
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware(Authenticate::class);  //TODO: Ændre den her til at have to startsider. En for brugere der er logged in,
                                                                                                   //      en for brugere der ikke er logget ind. <---- Ikke logget ind her

// Profile pages
Route::get('profile', [HomeController::class, 'profilePage'])->name('profile'); //De her skal nok skifte til ProfileController.
Route::get('userprofile', [HomeController::class, 'userProfilePage'])->name('userprofile'); //TODO: Authenticate
Route::get('editprofile', [HomeController::class, 'editProfilePage'])->name('editprofile'); //TODO: Authenticate

// Games pages
Route::get('games', [GamesController::class, 'index'])->name('games');
Route::get('games/blackjack', [GamesController::class, 'startBlackjack'])->name('blackjack');
Route::get('games/hit', [GamesController::class, 'hitBlackjack'])->name('blackjack.hit');

//Post/blog pages
Route::resource('posts', PostController::class);
Route::get('posts.index', [PostController::class, 'index'])->name('blog.index');

//FriendController routes metoder
Route::post('/', [FriendController::class, 'addFriend'])->name('addFriend')->middleware(Authenticate::class); //TODO: Istedet for '/' skal vi skifte den til sidebar.


// Login og authentication
Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');

    Route::get('register', Register::class)
        ->name('register');
});

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)
        ->name('logout');
});








//TEST PAGE!
Route::get('test', [GamesController::class, 'hitBlackjack'])->name('test');
