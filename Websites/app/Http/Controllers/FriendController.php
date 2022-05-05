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
        return $response;
    }
    public function getFriends()
    {
        $id = Auth::user()->id;
        $url = env('API_URL') . 'friends/getfriends/'.$id;
        $friends = Http::get($url)->json();
        return $friends['friend'];
    }

    public function getUser($username)
    {
        $id = Auth::user()->id;
        $url = env('API_URL') . 'friends/getOtherUser/'.$id.'/'.$username;
        $result = Http::get($url)->json();
        return $result;
    }
    public function deleteFriend($friend_id)
    {
        $id = Auth::user()->id;
        $url = env('API_URL') . 'friends/deletefriend/'.$id.'/'.$friend_id;
        $response = Http::get($url)->json();
        return $response;
    }
}
