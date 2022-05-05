<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Redirect;


class GamesController extends Controller
{
    public function index()
    {
        return view('games.index');
    }

    public function blackjack()
    {
        return view('games.blackjack.blackjack');
    }
    /* public function blackjack($result)
    {
        if ($result['status'] == 'success') {
            $jsonGame = $result['game'];
            $game['playerCard'] = $this->returnPlayerCard($jsonGame['player']);
            $game['dealerCard'] = $this->returnDealerCard($jsonGame['dealer']);
            $game['playerValue'] =  $jsonGame['playerValue'];
            $game['dealerValue'] = $jsonGame['dealerValue'];
            $game['gameStatus'] = $jsonGame['gameStatus'];
            return $game;
        }

        if ($result['status'] == 'error') {
            return redirect()->route('games')->with(['result' => $result]);
        }
    } */

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
        $result = json_decode($result, true);
        if ($result['status'] == 'success') {
            $jsonGame = $result['game'];
            $game['playerCard'] = $this->convertPlayerCard($jsonGame['player']);
            $game['dealerCard'] = $this->convertDealerCard($jsonGame['dealer']);
            $game['playerValue'] =  $jsonGame['playerValue'];
            $game['dealerValue'] = $jsonGame['dealerValue'];
            $game['gameStatus'] = $jsonGame['gameStatus'];
            return $game;
        }
        if ($result['status'] == 'error') {
            return $result;
        }
    }
    public function hitBlackjack()
    {
        $id = Auth::user()->id;
        $url = env('API_URL') . 'blackjack/' . $id . '/hit';
        $result = Http::get($url)->json();
        if ($result['status'] == 'success') {
            $jsonGame = $result['game'];
            $game['playerCard'] = $this->convertPlayerCard($jsonGame['player']);
            $game['dealerCard'] = $this->convertDealerCard($jsonGame['dealer']);
            $game['playerValue'] =  $jsonGame['playerValue'];
            $game['dealerValue'] = $jsonGame['dealerValue'];
            $game['gameStatus'] = $jsonGame['gameStatus'];
            return $game;
        }

        if ($result['status'] == 'error') {
            return redirect()->route('games')->with(['result' => $result]);
        }
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

        if ($result['status'] == 'success') {
            $jsonGame = $result['game'];
            $game['playerCard'] = $this->convertPlayerCard($jsonGame['player']);
            $game['dealerCard'] = $this->convertDealerCard($jsonGame['dealer']);
            $game['playerValue'] =  $jsonGame['playerValue'];
            $game['dealerValue'] = $jsonGame['dealerValue'];
            $game['gameStatus'] = $jsonGame['gameStatus'];
            return $game;
        }

        if ($result['status'] == 'error') {
            return redirect()->route('games')->with(['result' => $result]);
        }
    }
    public function convertPlayerCard($card)
    {
        foreach ($card as $player) {
            $playerCard[] = $player['rank'] . "_of_" . $player['suit'];
        }
        return $playerCard;
    }
    public function convertDealerCard($card)
    {
        foreach ($card as $dealer) {
            $dealerCard[] = $dealer['rank'] . "_of_" . $dealer['suit'];
        }
        return $dealerCard;
    }
}
