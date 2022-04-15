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
        $coin = Coin::where('user_id', $id)
                    ->select('coins_amount')
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
    public function updateCoin(Request $request, $winlose, $token)       //Master token som altid er der for programmet.
    {
        $user = User::where('token', $token)->first(); //TODO: Ikke rigtig. Vi skal få token fra et andet sted. Ikke fra User Scheme
        $userid = $user->id;
        try {
            if($winlose == true) {
                $coin = Coin::where('user_id', $userid)->first();
                $coin->amount += $request;
                $coin->save();
            } else {
                $coin = Coin::where('user_id', $userid)->first();
                $coin->amount -= $request;
                $coin->save();
            }  //TODO: Tjek om dette virker, hvis ikke, fix det. (Spillet bestemmer win/lose)
            return response()->json(['success' => 'Coin amount updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Coin amount could not be updated'], 500);
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
