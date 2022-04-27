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
            $friend_ids = Friend::where('sender_id', $id)->select('receiver_id')->get();

            foreach ($friend_ids as $friend_id) {
                $friend = $friend_id->receiver_id;
                $friends[] = $userController->getUsername($friend);
            }
            return response()->json(['success' => true, 'friend' => $friends]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'friend' => ['friendless pig']]);
        }
    }
    //is friend
    public function isFriend($id, $friend_id)
    {
        //if $id and $friend_id have each other on the friend table
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
                'isFriend' => 2
            ]);
        }
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
