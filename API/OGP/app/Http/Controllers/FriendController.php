<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\Friend;
use GrahamCampbell\ResultType\Success;

class FriendController extends Controller
{
    //add friend
    public function addFriend($id, $friend_id)
    {
        try {
            $friend = Friend::create([
                'sender_id' => $id,
                'receiver_id' => $friend_id,
            ]);
            if(Friend::where('receiver_id', $id)->where('sender_id', $friend_id)->first() != null)
            {
                Friend::where('receiver_id', $id)
                ->where('sender_id', $friend_id)
                ->update(['is_accepted' => 1]) &&
                Friend::where('sender_id', $id)
                ->where('receiver_id', $friend_id)
                ->update(['is_accepted' => 1]);
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }

    //get friends
    public function getFriends($id)
    {
        $userController = new UserController();
        try {
            $friend_ids = Friend::where('sender_id', $id)
                ->where('is_accepted', 1)
                ->select('receiver_id')
                ->get();
            //TODO: Kun dem hvor begge er venner
            foreach ($friend_ids as $friend_id) {
                $friend = $friend_id->receiver_id;
                $friends[] = $userController->getUsername($friend);
            }
            return response()->json(['success' => true, 'friend' => $friends]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'friend' => ['friendless pig']]);
        }
    }

    //get pending friends
    public function getFriendRequests($id)
    {
        $userController = new UserController();
        try {
            $friend_ids = Friend::where('receiver_id', $id)
                ->where('is_accepted', 0)
                ->select('sender_id')
                ->get();
            //TODO: Kun dem hvor de er venner med brugeren, men brugeren ikke venner med dem
            foreach ($friend_ids as $friend_id) {
                $friend = $friend_id->sender_id;
                $friends[] = $userController->getUsername($friend);
            }
            return response()->json(['success' => true, 'friend' => $friends]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'friend' => ['no pending friends']]);
        }
    }

    //is friend
    public function isFriend($id, $friend_id)
    {
        //Both are friends
        if (
            Friend::where('sender_id', $id)
            ->where('receiver_id', $friend_id)
            ->exists() &&
            Friend::where('sender_id', $friend_id)
            ->where('receiver_id', $id)
            ->exists()
        ) {
            return response()->json([
                'success' => true,
                'isFriend' => 3
            ]);
        }
        //I have requested a friend
        if (
            Friend::where('sender_id', $id)
                ->where('receiver_id', $friend_id)
                ->exists() &&
            !Friend::where('sender_id', $friend_id)
                ->where('receiver_id', $id)
                ->exists()
        ) {
            return response()->json([
                'success' => true,
                'isFriend' => 2
            ]);
        }
        //Other person has requested me
        if (
            !Friend::where('sender_id', $id)
                ->where('receiver_id', $friend_id)
                ->exists() &&
            Friend::where('sender_id', $friend_id)
                ->where('receiver_id', $id)
                ->exists()
        ) {
            return response()->json([
                'success' => true,
                'isFriend' => 1
            ]);
        }
        //Not friends
        if (
            !Friend::where('sender_id', $id)
                ->where('receiver_id', $friend_id)
                ->exists() &&
            !Friend::where('sender_id', $friend_id)
                ->where('receiver_id', $id)
                ->exists()
        ) {
            return response()->json([
                'success' => true,
                'isFriend' => 0
            ]);
        }
    }




    //delete friend
    public function deleteFriend($id, $friend_id)
    {
        //delete friend by id
        try {
            Friend::where('sender_id', $id)
                ->where('receiver_id', $friend_id)
                ->delete();
            Friend::where('sender_id', $friend_id)
                ->where('receiver_id', $id)
                ->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }
}
