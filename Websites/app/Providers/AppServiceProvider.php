<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\FriendController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.header', function ($view) {

            $coinController = new CoinController();
            $coins = $coinController->getCoins();

            return $view->with('coins', $coins);
        });

        View::composer('layouts.sidebar', function ($view) {
            $friendController = new FriendController();
            $friends = $friendController->getFriends();

            return $view->with('friends', $friends);
        });

        View::composer('layouts.sidebar', function ($view) {
            $friendController = new FriendController();
            $friendRequests = $friendController->getFriendRequests();

            return $view->with('friendRequests', $friendRequests);
        });
    }
}
