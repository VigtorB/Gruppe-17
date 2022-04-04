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
        $user = env('API_URL') .'users/'.$username;
        $friend_id = $user['id'];
                                                        // TODO: En if else statement til at tjekke om brugeren allerede er tilføjet som ven.
        $url = env('API_URL') . 'friend/addFriend/';
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
        $user = env('API_URL') . 'users/'.$username;
        $friend_id = $user['id'];
        $url = env('API_URL') . 'friend/acceptFriend/';
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
        $url = env('API_URL') . 'friends/'.$id;
        $friends = Http::get($url)->json();
        return $friends['friend'];
    }
    public function deleteFriend($username)
    {
        $user = env('API_URL') . 'users/'.$username;
        $friend_id = $user['id'];
        $url = env('API_URL') . 'friend/deleteFriend/'.$friend_id;
        return Http::delete($url);
    }
}
