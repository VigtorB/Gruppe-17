<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;

class CoinController extends Controller
{

    public function getCoins()
    {
        $id = Auth::user()->id;
        //parse $id to string
        //$id = (string)$id;
        //$authController = new AuthController();
        //$id = $authController->getUserId();
        $url = "http://localhost:8000/api/coins/" . $id;
        $coins = Http::get($url)->json();
        dd($coins['coins_amount']); //kommer med en null værdi
        return view('test', ['coins' => $coins['coins_amount']] );


    }
}
