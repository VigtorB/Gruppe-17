<?php

namespace App\Http\Controllers\GamesController;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use App\Models\BlackjackModels\Game;
use App\Models\BlackjackModels\Player;
use App\Models\BlackjackModels\Card;
use App\Models\BlackjackModels\Deck;

class BlackjackController extends Controller
{
    public function index()
    {
        $game = new Game();
        try {
            $id = Auth::user()->id;
            $url = env('BAPI_URL') .  $id;
            $game = Http::get($url)->json();
        } catch (\Exception $e) {
            return redirect('/');
        }

        return view('games.blackjack')->with('title', 'Blackjack');
    }
}
