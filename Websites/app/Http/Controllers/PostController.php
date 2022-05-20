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
    public function updateComment($comment_id, $content)
    {
        $url = env('API_URL') . 'comments/'.$comment_id;
        $ch = curl_init($url);
        $data = array(
            'comment_id' => $comment_id,
            'content' => $content,
        );
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        return $result;
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
