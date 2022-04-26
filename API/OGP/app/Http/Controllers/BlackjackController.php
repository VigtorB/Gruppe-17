<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\FlareClient\Http\Exceptions\BadResponse;

class BlackjackController extends Controller
{
    public function startBlackjack(Request $request)
    {

        $CoinController = new CoinController();

        //initiate bet
        $CoinController->pendingBet($request);

        //TODO: Gør det umuligt at spille, hvis der ikke er nok penge tilbage

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
        if($response['gameStatus'] == 'player win'){
            $addOrSubtract = 'add';
            $CoinController->updateCoin($id, $addOrSubtract);
        }
        if($response['gameStatus'] == 'dealer bust' || $response['gameStatus'] == 'dealer blackjack' || $response['gameStatus'] == 'dealer win'){
            $addOrSubtract = 'subtract';
            $CoinController->updateCoin($id, $addOrSubtract);
        }
        if($response['gameStatus'] == 'draw'){
            $addOrSubtract = 'draw';
            $CoinController->updateCoin($id, $addOrSubtract);
        }
        return $response;
    }


}
