<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
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
            'sender_id' => $request->user_id,
            'receiver_id' => $request->friend_id,
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
            'sender_id' => $request->user_id,
            'receiver_id' => $request->friend_id,
        ]);
        return response()->json(['success' => true]);
    }catch(\Exception $e){
        return response()->json(['success' => false]);
    }

    }

    //get friends
    public function getFriends($id)
    {
        $userController = new UserController();
        $friend_ids = Friend::where('sender_id', $id)->select('receiver_id')->get();
        foreach($friend_ids as $friend_id){
            $friend = $friend_id->friend_user;
            $friends[] = $userController->getUsername($friend);
        }
        return response()->json(['success' => true, 'friend' => $friends]);
    }

    //delete friend
    public function deleteFriend(Request $request)
    {
        $friend = Friend::where('sender_id', $request->user_id)->where('receiver_id', $request->friend_id)->delete();
        return response()->json(['success' => true]);
    }
}
