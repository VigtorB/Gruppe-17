<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GamesController extends Controller
{
    public function index()
    {
        return view('games.index');
    }

    public function startBlackjack($coin_bet)
    {
        $id = Auth::user()->id;
        $url = env('API_URL') . 'blackjack/';
        $ch = curl_init($url);
        $data = array(
            'id' => $id,
            'coin_bet' => $coin_bet,
        );

        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        dd($result);
        return view('games.blackjack')->with($result);
    }
    public function hitBlackjack()
    {
        $id = Auth::user()->id;
        $url = env('API_URL') . 'blackjack/'.$id.'hit';
        $result = Http::get($url)->json();

        dd($result);
        //return view('games.blackjack')->with($result);
    }

    public function standBlackjack($id)
    {
        $id = Auth::user()->id;
        $url = env('API_URL') . 'blackjack/'.$id.'stand';
        $result = Http::get($url)->json();

        dd($result);
        //return view('games.blackjack')->with($result);
    }
}
