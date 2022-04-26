<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Redirect;

use App\Models\BlackjackModels\Card;
use App\Models\BlackjackModels\Game;

class GamesController extends Controller
{
    public function index()
    {
        return view('games.index');
    }

    public function startBlackjack()
    {
        $coin_bet = 100; //TODO: Make this dynamic, based on users bet input
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
        //dd($result);
        $result = json_decode($result, true);

        //dd($result[]);
        return view('games.blackjack'); //TODO: husk with('result')
    }
    public function hitBlackjack()
    {
        $card = new Card();
        $game = new Game();

        $id = Auth::user()->id;
        $url = env('API_URL') . 'blackjack/'.$id.'/hit';
        $result = Http::get($url)->json();
        $game->GameStatus = $result['gameStatus'];
        $game->Player = $result['player'];
        $game->Dealer = $result['dealer'];

        dd($result['gameStatus']);
        //return redirect()->route('blackjack')->with($result); //TODO: husk with('result')
    }

    public function standBlackjack()
    {
        $id = Auth::user()->id;
        $url = env('API_URL') . 'blackjack/'.$id.'stand';
        $result = Http::get($url)->json();

        dd($result);
        //return view('games.blackjack')->with($result);
    }
}
