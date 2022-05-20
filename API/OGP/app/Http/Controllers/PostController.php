<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;


class PostController extends Controller
{
    // get all comments
    public function getComments($user_id)
    {
        try {
            $comments = Comment::where('user_receiver_id', $user_id)
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(['success' => true, 'comments' => $comments]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }

    // add comment
    public function addComment(Request $request)
    {
        $sender_username = $request->input('sender_username');
        $user_receiver_id = $request->input('user_receiver_id');
        $content = $request->input('content');
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
    public function updateComment(Request $request)
    {
        $comment_id = $request->input('comment_id');
        $content = $request->input('content');
        try {
            Comment::where('id', $comment_id)
                ->update(['content' => $content]);
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
