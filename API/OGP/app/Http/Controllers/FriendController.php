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
                $friends = null;
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
                $friendRequests = null;
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
            if($id == $otherUser->id){
                return response()->json(['success' => false]);
            }
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
        //make empty arrays
        /* $friend = [];
        $friend2 = []; */
        $friendStatus = [];

        //db call thga
        $friendStatus1 = Friend::where('sender_id', $id)
            ->where('receiver_id', $friend_id)
            ->get();

        $friendStatus2 = Friend::where('sender_id', $friend_id)
            ->where('receiver_id', $id)
            ->get();



        if ($friendStatus1->isEmpty() && $friendStatus2->isEmpty()) {
            return 0;
        }
        if($friendStatus1->isEmpty() && !$friendStatus2->isEmpty()){
            return 1;
        }
        else{
            return 2;
        }
        return 3;

        /* $friendStatus = Friend::where(function($query) use($id, $friend_id) {
                $query->where("sender_id", $id)->where("receiver_id", $friend_id);
              })->andWhere(function($query) use($id, $friend_id) {
                $query->where("receiver_id", $id)->where("sender_id", $friend_id);
              });
              if($friendStatus->count() > 0){
                    if($friendStatus->count() == 2){
                        return 3;
                    }
                    if($friendStatus[0]['sender_id'] == $id){
                        return 2;
                    }
                    if($friendStatus[0]['receiver_id'] == $friend_id){
                        return 1;
                    }
                }
                return 0; */
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
