<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FriendController extends Controller
{
    public function addFriend($friend_id)
    {
        $id = Auth::user()->id;
        $url = env('API_URL') . 'friends/addfriend/'.$id.'/'.$friend_id;
        $response = Http::get($url)->json();
        return redirect()->route('home');
    }
    public function getFriends()
    {
        $id = Auth::user()->id;
        $url = env('API_URL') . 'friends/getfriends/'.$id;
        $friends = Http::get($url)->json();
        if($friends == null)
        {
            return $friends['No friends :('];
        }
        else
        {
            return $friends['friend'];
        }
        return $friends['friend'];
    }
    public function getFriend($username)
    {
        $url = env('API_URL') . 'user/'.$username;
        $result = Http::get($url)->json();
        $friend_id = $result['id'];
        $id = Auth::user()->id;
        $url = env('API_URL') . 'friends/isfriend/'.$id.'/'.$friend_id;
        $result2 = Http::get($url)->json();
        return view('profile.friendprofile', ['user' => $result], ['isFriend' => $result2]);
        //TODO: GØR SÅ DER KUN ER 1 RESULT
    }
    public function deleteFriend($friend_id)
    {
        $id = Auth::user()->id;
        $url = env('API_URL') . 'friends/deletefriend/'.$id.'/'.$friend_id;
        $response = Http::get($url)->json();
        return redirect()->route('home');
    }
}
