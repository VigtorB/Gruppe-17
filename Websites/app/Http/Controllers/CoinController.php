<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController; //Brug denne for at få fat i user og user id


class CoinController extends Controller
{
    public function getCoins($id)
    {
        $coins = Request::get('http://localhost:8000/api/coins/'+$id)->json();
        return $coins;
    }

}
