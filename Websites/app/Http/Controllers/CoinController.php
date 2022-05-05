<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use App\Models\Coin;

class CoinController extends Controller
{

    public function getCoins()
    {
        $coin = new Coin();

        $id = Auth::user()->id;
        $url = env('API_URL') . 'coins/' . $id;
        $coins = Http::get($url)->json();

        $coin->coins_amount = $coins['balance'];
        //decode coin
        return $coins['balance'];
    }
}
