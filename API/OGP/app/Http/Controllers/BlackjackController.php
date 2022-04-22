<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BlackjackController extends Controller
{
    public string $addOrSubtract;
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
        $decodedResponse = json_decode($response, true);
        if($decodedResponse['gameStatus'] == 'blackjack'){
            $addOrSubtract = 'add';
            $CoinController->updateBet($id, $addOrSubtract);
        }

        return $response;
    }

    public function hit($id)
    {
        $CoinController = new CoinController();

        //hit game and receive $game
        $url = env('BAPI_URL') . 'blackjack/'.$id.'/hit';
        $response = Http::get($url)->json();

        //updateBet
        $decodedResponse = json_decode($response, true);
        if($decodedResponse['gameStatus'] == 'blackjack'){
            $addOrSubtract = 'add';
            $CoinController->updateBet($id, $addOrSubtract);
        }
        if($decodedResponse['gameStatus'] == 'bust'){
            $addOrSubtract = 'subtract';
            $CoinController->updateBet($id, $addOrSubtract);
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
            $CoinController->updateBet($id, $addOrSubtract);
        }
        if($decodedResponse['gameStatus'] == 'bust' || $decodedResponse['gameStatus'] == 'dealer blackjack'){
            $addOrSubtract = 'subtract';
            $CoinController->updateBet($id, $addOrSubtract);
        }
        if($decodedResponse['gameStatus'] == 'draw'){
            $addOrSubtract = 'draw';
            $CoinController->updateBet($id, $addOrSubtract);
        }
        return $response;
    }


}
