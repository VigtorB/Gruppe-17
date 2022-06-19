<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Models\Coin;

class CoinController extends Controller
{
    public function storeView()
    {
        return view('store.store');
    }

    public function buyCoin(Request $request)
    {
        /* $id = Auth::user()->id;
        //$amount = $oldCoin->coin_amount + $request->amount;

        $url = env('API_URL') . 'coins/';
        $coin = Http::put($url, [
            'user_id' => $id,
            'coin_amount' => $amount
        ])->json(); */


    }

        /* $url = 'http://localhost:8000/api/coins';
        $data = [
            'coins_amount' => $amount,
            'user_id' => Auth::user()->id
        ];
        $response = Http::post($url, $data);
        $coin = $response->json();
        return $coin; */
    /* } */

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
