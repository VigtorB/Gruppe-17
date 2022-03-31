<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FriendController;

class HomeController extends Controller
{
    /* private FriendController $friendController;
    private CoinController $coinController;
    //instanciate $friendController
    public function __construct( FriendController $friendController, CoinController $coinController )
    {
        $this->friendController = $friendController;
        $this->coinController = $coinController;
    } */

    public function index(){
        $friendController = new FriendController();
        $coinController = new CoinController();
        $friends = $friendController->getFriends();
        $coins = $coinController->getCoins();
        return view('welcome')
            ->with('coins', $coins);
    }

    public function profilePage()
    {

    }
}
