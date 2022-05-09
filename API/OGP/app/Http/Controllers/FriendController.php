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
            //db call that constructs array of mutual friends.
            $friend_ids = Friend::where('sender_id', $id)
                ->where('is_accepted', 1)
                ->select('receiver_id')
                ->get();
            //defines $friends as null if user has no mutual friends.
            if ($friend_ids->isEmpty()) {
                $friends = null;
            }
            //else, define $friends as an array of mutual friends.
            else {
                foreach ($friend_ids as $friend_id) {
                    $friend = $friend_id->receiver_id;
                    $friends[] = $userController->getUsername($friend);
                }
            }
            //db call that constructs array of friend requests.
            $friend_ids = Friend::where('receiver_id', $id)
                ->where('is_accepted', 0)
                ->select('sender_id')
                ->get();
            //defines $requests as null if user has no friend requests.
            if ($friend_ids->isEmpty()) {
                $friendRequests = null;
            }
            //else, define $requests as an array of friend requests.
            else {
                foreach ($friend_ids as $friend_id) {
                    $friend = $friend_id->sender_id;
                    $friendRequests[] = $userController->getUsername($friend);
                }
            }
            //constructs a data package able to return multiple variables to the frontend.
            $data = [
                'friends' => $friends,
                'friendRequests' => $friendRequests,
            ];
            return response()->json(['success' => true, 'friend' => $data]);
        }
        catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
        /* catch (\Exception $e) {
            $data = [
                'friends' => ['No friends :('],
                'friendRequests' => ['no friend requests :('],
            ];
            return response()->json(['success' => false, 'friend' => $data]);
        } */
    }

    //get other user
    public function getOtherUser($id, $username)
    {
        try {
            $userController = new UserController();
            $otherUser = $userController->getUser($username);
            if ($id == $otherUser->id) {
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
        //db calls that grabs both users if they exist.
        $friendStatus1 = Friend::where('sender_id', $id)
            ->where('receiver_id', $friend_id)
            ->get();
        $friendStatus2 = Friend::where('sender_id', $friend_id)
            ->where('receiver_id', $id)
            ->get();

        //checking arrays to tell whether users are friends or not,
        //3 = both are friends
        //2 = user is friend, other user is not, pending friend
        //1 = other user is friend, user is not, friend request
        //0 = neither are friends
        if ($friendStatus1->isEmpty() && $friendStatus2->isEmpty()) {
            return 0;
        }
        if ($friendStatus1->isEmpty() && !$friendStatus2->isEmpty()) {
            return 1;
        } else {
            return 2;
        }
        return 3;
    }

    /*
        //Generating empty arrays
        $friendStatus1 = [];
        $friendStatus2 = [];
        */

    //Attempt at turning DB call into one instead of 2 calls
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
