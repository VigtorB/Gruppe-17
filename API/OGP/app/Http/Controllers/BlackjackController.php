<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BlackjackController extends Controller
{
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

    public function hit($id)
    {
        $CoinController = new CoinController();

        //hit game and receive $game
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
    public function stand($id)
    {
        $CoinController = new CoinController();

        //stand game and receive $game
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
