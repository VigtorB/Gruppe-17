<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function games()
    {
        return view('games.index');
    }

    public function startBlackjack()
    {
        return view('games.blackjack');
    }
}
