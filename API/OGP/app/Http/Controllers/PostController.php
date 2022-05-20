<?php

namespace App\Http\Controllers;

use App\Models\Comment;


class PostController extends Controller
{
    // get all comments
    public function getComments($user_id)
    {
        $comments = Comment::where('user_receiver_id', $user_id)->get();
        return response()->json($comments);
    }

    // add comment
    public function addComment($user_receiver_id, $sender_username, $content)
    {
        try {
            Comment::create([
                'user_receiver_id' => $user_receiver_id,
                'sender_username' => $sender_username,
                'content' => $content,
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }
    // edit comment
    public function updateComment($id, $content)
    {
        try {
            Comment::where('id', $id)->update(['content' => $content]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }

    // delete comment
    public function deleteComment($id)
    {
        try {
            Comment::destroy($id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }
}
