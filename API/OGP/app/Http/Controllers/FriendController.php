<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;

class FriendController extends Controller
{
    //add friend
    public function addFriend(Request $request)
    {
        try{
        $friend_id = $request->friend_id;
        $friend = Friend::create([
            'my_user' => $request->user_id,
            'friend_user' => $request->friend_id,
        ]);
        return response()->json(['success' => true]);
    }catch(\Exception $e){
        return response()->json(['success' => false]);
    }
    }
    //accept friend
    public function acceptFriend(Request $request)
    {
        try{
        $friend_id = $request->friend_id;
        $friend = Friend::create([
            'my_user' => $request->user_id,
            'friend_user' => $request->friend_id,
        ]);
        return response()->json(['success' => true]);
    }catch(\Exception $e){
        return response()->json(['success' => false]);
    }

    }

    //get friends
    public function getFriends($id)
    {
        $friends = Friend::where('my_user', $id)->select('friend_user')->get();
        return response()->json(['success' => true, 'friend' => $friends]);
    }

    //delete friend
    public function deleteFriend(Request $request)
    {
        $friend = Friend::where('my_user', $request->user_id)->where('friend_user', $request->friend_id)->delete();
        return response()->json(['success' => true]);
    }
}
