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
        $coin = Coin::where('coin_owner', $id)
                    ->select('balance')
                    ->get()
                    ->first();

        return response()->json($coin);
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
        //add to coin db
        $coin = Coin::where('coin_owner', $request->id)
                    ->update(['coin_bet' => $request->coin_bet]);

    }

    public function updateCoin($id, $addOrSubtract)
    {
        if($addOrSubtract = 'add')
        {
            $coin = Coin::where('coin_owner', $id)
                        ->put(['balance' => 'balance' + 'coin_bet']);
        }
        if($addOrSubtract = 'subtract')
        {
            $coin = Coin::where('coin_owner', $id)
                        ->put(['balance' => 'balance' - 'coin_bet']);
        }
        if($addOrSubtract = 'draw')
        {
            $coin = Coin::where('coin_owner', $id)
                        ->put(['coin_bet' => 0]);
        }
    }

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
