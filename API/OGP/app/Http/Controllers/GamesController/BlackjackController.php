<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GamesController extends Controller
{
    public function games()
    {
        return view('games.index');
    }

    public function startBlackjack(Request $request)
    {

        $CoinController = new CoinController();

        //initiate bet
        $CoinController->pendingBet($request);

        //launch game and receive $game
        $id = $request->id;
        $url = env('BAPI_URL') . 'blackjack/'.$id;
        $response = Http::get($url)->json();
        /* dd($response); */
        //updateBet
        if($response['gameStatus'] == 'blackjack'){
            $CoinController->updateBet("add");
        }

        return $response;
    }

    public function hit(Request $request)
    {
        $CoinController = new CoinController();

        //hit game and receive $game
        $id = $request->id;
        $url = env('BAPI_URL') . 'blackjack/'.$id.'/hit';
        $game = Http::get($url)->json();

        //updateBet
        if($game['gameStatus'] == 'blackjack'){
            $CoinController->updateBet("add");
        }
        if($game['gameStatus'] == 'bust'){
            $CoinController->updateBet("subtract");
        }
        return $game['game'];
    }
    public function stand(Request $request)
    {
        $CoinController = new CoinController();

        //stand game and receive $game
        $id = $request->id;
        $url = env('BAPI_URL') . 'blackjack/'.$id.'/stand';
        $game = Http::get($url)->json();

        //updateBet
        if($game['gameStatus'] == 'won'){
            $CoinController->updateBet("add");
        }
        if($game['gameStatus'] == 'bust' || $game['gameStatus'] == 'dealer blackjack'){
            $CoinController->updateBet("subtract");
        }
        if($game['gameStatus'] == 'draw'){
            $CoinController->updateBet("draw");
        }
        return $game['game'];
    }


}
