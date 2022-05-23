<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\DataCollector\AjaxDataCollector;

class PostController extends Controller
{
    // get all comments
    public function getComments($user_id)
    {
        $url = env('API_URL') . 'comments/'.$user_id;
        $comments = Http::get($url)->json();
        return $comments['comments'];
    }

    // add comment
    public function addComment(Request $request)
    {
        $userReceiverId = $request->input('otherUserId');
        $content = $request->input('content');
        $userSenderName = Auth::user()->username;

        $url = env('API_URL') . 'comments/';
        $comment = Http::post($url, [
            'user_receiver_id' => $userReceiverId,
            'sender_username' => $userSenderName,
            'content' => $content
        ])->json();
        return $comment;
    }

    // update comment
    public function updateComment(Request $request)
    {
        $comment_id = $request->input('comment_id');
        $content = $request->input('content');
        //put method
        $url = env('API_URL') . 'comments/'.$comment_id;
        $comment = Http::put($url, [
            'comment_id' => $comment_id,
            'content' => $content
        ])->json();
        return $comment;
    }

    // delete comment
    public function deleteComment($id)
    {
        $url = env('API_URL') . 'comments/'.$id;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        return $result;
    }
}
