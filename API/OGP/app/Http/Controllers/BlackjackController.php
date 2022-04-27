<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\FlareClient\Http\Exceptions\BadResponse;

class BlackjackController extends Controller
{
    public function startBlackjack(Request $request)
    {
        $id = $request->id;
        $coin_bet = $request->coin_bet;

        $coinController = new CoinController();

        $balance = $coinController->getCoinBalance($id);
        if($balance < $coin_bet)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'You do not have enough coins to play this game.'
            ], 400);
            /* return $result = [
                'status' => 'error',
                'message' => 'You do not have enough coins to play this game.'
            ]; */

        }

        //initiate bet
        $coinController->pendingBet($request);

        //TODO: Gør det umuligt at spille, hvis der ikke er nok penge tilbage

        //launch game and receive $game
        $url = env('BAPI_URL') . 'blackjack/'.$id;
        $response = Http::get($url)->json();
        //updateBet
        if($response['gameStatus'] == 'pending'){
            return response()->json([
                'status' => 'success',
                'message' => 'Game is pending',
                'game' => $response
            ], 200);
            /* return response($response)->json(['success' => 'Game is already in progress'], 200); */
        }
        if($response['gameStatus'] == 'blackjack'){
            $addOrSubtract = 'add';
            $coinController->updateCoin($id, $addOrSubtract);
            return response()->json([
                'status' => 'success',
                'message' => 'You won the game',
                'game' => $response
            ], 200);
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
        return response()->json([
            'status' => 'success',
            'message' => 'You hit',
            'game' => $response
        ], 200);
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
        return response()->json([
            'status' => 'success',
            'message' => 'You stand',
            'game' => $response
        ], 200);
    }


}
