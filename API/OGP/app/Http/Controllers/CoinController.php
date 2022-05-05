<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coin;
use App\Models\User;

class CoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCoin(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCoins($id)
    {
        //show current amount of coins
        try{
            $coin = Coin::where('coin_owner', $id)
            ->select('balance')
            ->get()
            ->first();
            return response()->json($coin);
        }
        catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    /**
     * A token of the user is sent here, and amount $request is also sent from the game api
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pendingBet($request)       //Master token som altid er der for programmet.
    {
        Coin::where('coin_owner', $request->id)
            ->update(['coin_bet' => $request->coin_bet]);
    }
    public function getCoinBalance($id)
    {
        $coin = Coin::where('coin_owner', $id)
            ->select('balance')
            ->get()
            ->first();
        return $coin->balance;
    }

    public function updateCoin($id, $addOrSubtract)
    {
        //TODO: Sørg for man ikke kan bette mere end man har
        $coin_bet = Coin::where('coin_owner', $id)
            ->select('coin_bet')
            ->get()
            ->first();
        $coin_balance = Coin::where('coin_owner', $id)
            ->select('balance')
            ->get()
            ->first();

        if ($addOrSubtract == 'add') {
            $new_balance = $coin_balance->balance + $coin_bet->coin_bet;
            Coin::where('coin_owner', $id)
                ->update(['balance' => $new_balance]);
            Coin::where('coin_owner', $id)
                ->update(['coin_bet' => 0]);
        }
        if ($addOrSubtract == 'subtract') {
            $new_balance = $coin_balance->balance - $coin_bet->coin_bet;
            Coin::where('coin_owner', $id)
                ->update(['balance' => $new_balance]);
            Coin::where('coin_owner', $id)
                ->update(['coin_bet' => 0]);
        }
        if ($addOrSubtract == 'draw') {
            Coin::where('coin_owner', $id)
                ->update(['coin_bet' => 0]);
        }
    }
    /* $coin = Coin::create([
        'coin_owner' => $user->id,
        'balance' => 1000,
        'coin_bet' => 0,
    ]); */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyCoin($id)
    {
        //
    }
}
