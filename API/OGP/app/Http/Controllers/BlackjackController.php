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
        //updateBet
        if($response['gameStatus'] == 'pending'){
            return $response;
        }
        if($response['gameStatus'] == 'blackjack'){
            $addOrSubtract = 'add';
            $CoinController->updateCoin($id, $addOrSubtract);
            return $response;
        }
        /* dd($response); */
    }

    public function hit($id)
    {
        $CoinController = new CoinController();

        //hit game and receive $game
        $url = env('BAPI_URL') . 'blackjack/'.$id.'/hit';
        $response = Http::get($url)->json();


        //updateBet
        if($response['gameStatus'] == 'blackjack'){
            $addOrSubtract = 'add';
            $CoinController->updateCoin($id, $addOrSubtract);
        }
        if($response['gameStatus'] == 'bust'){
            $addOrSubtract = 'subtract';
            $CoinController->updateCoin($id, $addOrSubtract);
        }
        return $response;
    }
    public function stand($id)
    {
        $CoinController = new CoinController();

        //stand game and receive $game
        $url = env('BAPI_URL') . 'blackjack/'.$id.'/stand';
        $response = Http::get($url)->json();

        //updateBet
        $decodedResponse = json_decode($response, true);
        if($decodedResponse['gameStatus'] == 'won'){
            $addOrSubtract = 'add';
            $CoinController->updateCoin($id, $addOrSubtract);
        }
        if($decodedResponse['gameStatus'] == 'bust' || $decodedResponse['GameStatus'] == 'dealer blackjack'){
            $addOrSubtract = 'subtract';
            $CoinController->updateCoin($id, $addOrSubtract);
        }
        if($decodedResponse['gameStatus'] == 'draw'){
            $addOrSubtract = 'draw';
            $CoinController->updateCoin($id, $addOrSubtract);
        }
        return $response;
    }


}
