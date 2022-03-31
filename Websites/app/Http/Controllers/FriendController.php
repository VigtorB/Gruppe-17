<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FriendController extends Controller
{
    public function addFriend($username)
    {
        $id = Auth::user()->id;
        $user = 'http://localhost:8000/api/users/'.$username;
        $friend_id = $user['id'];
        $url = 'http://localhost:8000/api/friend/addFriend/';
        $ch = curl_init($url);
        $data = array(
            'user_id_fl' => $id,
            'friend_id' => $friend_id,
        );
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function acceptFriend($username)
    {
        $id = Auth::user()->id;
        $user = 'http://localhost:8000/api/users/'.$username;
        $friend_id = $user['id'];
        $url = 'http://localhost:8000/api/friend/acceptFriend/';
        $ch = curl_init($url);
        $data = array(
            'user_id_fl' => $id,
            'friend_id' => $friend_id,
        );
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function getFriends()
    {
        $id = Auth::user()->id;
        $url = 'http://localhost:8000/api/friends/'.$id;
        $friends = Http::get($url)->json();
        //dd($friends['friend'][0]);
            return view('welcome', ['friends' => $friends['friend']]);
          //Denne skal henvendes til sidebar
        /* $store = Store::all(); // got this from database model
        return view('store')->with('store', $store); */
    }
    public function deleteFriend($username)
    {
        $user = 'http://localhost:8000/api/users/'.$username;
        $friend_id = $user['id'];
        $url = 'http://localhost:8000/api/friend/deleteFriend/'.$friend_id;
        return Http::delete($url);
    }
}
