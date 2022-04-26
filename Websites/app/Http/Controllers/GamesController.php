<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Redirect;

use App\Models\BlackjackModels\Card;
use App\Models\BlackjackModels\Game;

class GamesController extends Controller
{
    public function index()
    {
        return view('games.index');
    }
    public function blackjack($result)
    {
        $playerCard = $this->returnPlayerCard($result['player']);
        $dealerCard = $this->returnDealerCard($result['dealer']);
        $playerValue = $result['playerValue'];
        $dealerValue = $result['dealerValue'];
        /* if($result['gameStatus'] != 'pending')
        {
            return view('games.blackjack.blackjack')->with('playerCard', $playerCard)->with('dealerCard', $dealerCard)->with('playerValue', $playerValue)->with('dealerValue', $dealerValue)->with('gameStatus', $result['gameStatus']);
        } */

        return view('games.blackjack.blackjack')->with('playerCard', $playerCard)->with('dealerCard', $dealerCard)->with('playerValue', $playerValue)->with('dealerValue', $dealerValue)->with('gameStatus', $result['gameStatus']);
    }

    public function startBlackjack()
    {

        $coin_bet = 100; //TODO: Make this dynamic, based on users bet input
        $id = Auth::user()->id;
        $url = env('API_URL') . 'blackjack/';
        $ch = curl_init($url);
        $data = array(
            'id' => $id,
            'coin_bet' => $coin_bet,
        );

        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        //dd($result);
        $result = json_decode($result, true);
        /* $playerCard = $this->returnPlayerCard($result['player']);
        $dealerCard = $this->returnDealerCard($result['dealer']);
        $playerValue = $result['playerValue'];
        $dealerValue = $result['dealerValue'];
         return view('games.blackjack.blackjack')->with('playerCard', $playerCard)->with('dealerCard', $dealerCard)->with('playerValue', $playerValue)->with('dealerValue', $dealerValue); */
        return $this->blackjack($result);
    }
    public function hitBlackjack()
    {
        $id = Auth::user()->id;
        $url = env('API_URL') . 'blackjack/' . $id . '/hit';
        $result = Http::get($url)->json();
        /* $playerCard = $this->returnPlayerCard($result['player']);
        $dealerCard = $this->returnDealerCard($result['dealer']);
        $playerValue = $result['playerValue'];
        $dealerValue = $result['dealerValue'];
        return redirect()->route('blackjack')->with('playerCard', $playerCard)->with('dealerCard', $dealerCard)->with('playerValue', $playerValue)->with('dealerValue', $dealerValue); */
        return $this->blackjack($result);
    }

    public function standBlackjack()
    {
        $id = Auth::user()->id;
        $url = env('API_URL') . 'blackjack/' . $id . '/stand';
        $result = Http::get($url)->json();
        /* $playerCard = $this->returnPlayerCard($result['player']);
        $dealerCard = $this->returnDealerCard($result['dealer']);
        $playerValue = $result['playerValue'];
        $dealerValue = $result['dealerValue'];
        return redirect()->route('blackjack')->with('playerCard', $playerCard)->with('dealerCard', $dealerCard)->with('playerValue', $playerValue)->with('dealerValue', $dealerValue); */
        return $this->blackjack($result);
    }
    public function returnPlayerCard($card)
    {
        foreach ($card as $player) {
            $playerCard[] = $player['rank'] . "_of_" . $player['suit'];
        }
        return $playerCard;
    }
    public function returnDealerCard($card)
    {
        foreach ($card as $dealer) {
            $dealerCard[] = $dealer['rank'] . "_of_" . $dealer['suit'];
        }
        return $dealerCard;
    }
}
