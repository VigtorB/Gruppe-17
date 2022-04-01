<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


use Illuminate\Http\Request;
use App\Models\Coin;
use Illuminate\Support\Facades\Redirect;

class CoinController extends Controller
{

    public function getCoins()
    {
        $coin = new Coin();

        $id = Auth::user()->id;
        $url = env('API_URL') . 'coins/' . $id;
        $coins = Http::get($url)->json();
        $coin->coins_amount = $coins['coins_amount'];
        return $coins['coins_amount'];
    }
}
