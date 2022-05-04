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
            Friend::create([
                'sender_id' => $id,
                'receiver_id' => $friend_id,
            ]);
            if (Friend::where('receiver_id', $id)->where('sender_id', $friend_id)->first() != null) {
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
            if ($friend_ids->isEmpty()) {
                $friends = ['friendless pig'];
            } else {
                foreach ($friend_ids as $friend_id) {
                    $friend = $friend_id->receiver_id;
                    $friends[] = $userController->getUsername($friend);
                }
            }
            $friend_ids = Friend::where('receiver_id', $id)
                ->where('is_accepted', 0)
                ->select('sender_id')
                ->get();

            if ($friend_ids->isEmpty()) {
                $friendRequests = ['no friend requests you fuck'];
            } else {
                foreach ($friend_ids as $friend_id) {
                    $friend = $friend_id->sender_id;
                    $friendRequests[] = $userController->getUsername($friend);
                }
            }
            $data = [
                'friends' => $friends,
                'friendRequests' => $friendRequests,
            ];


            return response()->json(['success' => true, 'friend' => $data]);
        } catch (\Exception $e) {
            $data = [
                'friends' => ['friendless pig'],
                'friendRequests' => ['no friend requests you fuck'],
            ];
            return response()->json(['success' => false, 'friend' => $data]);
        }
    }

    //get friend
    public function getOtherUser($id, $username)
    {
        try {
            $userController = new UserController();
            $otherUser = $userController->getUser($username);
            $isFriend = $this->isFriend($id, $otherUser->id);
            $data = [
                'user' => $otherUser,
                'isFriend' => $isFriend
            ];
            if ($otherUser == null) {
                return response()->json(['success' => false]);
            }
            return response()->json(['success' => true, 'friend' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
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
            return 3;
            /* return response()->json([
                'success' => true,
                'isFriend' => 3
            ]); */
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
            return 2;
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
            return 1;
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
            return 0;
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
