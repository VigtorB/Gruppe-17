<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // get all comments
    public function getComments($user_id)
    {
        $url = env('API_URL') . 'comments/'.$user_id;
        $comments = Http::get($url)->json();
        return $comments;
    }

    // add comment
    public function addComment($user_receiver_id, $sender_username, $content)
    {
        $url = env('API_URL') . 'comments/';
        $ch = curl_init($url);
        $data = array(
            'user_receiver_id' => $user_receiver_id,
            'sender_username' => $sender_username,
            'content' => $content,
        );
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        return $result;
    }

    // update comment
    public function updateComment($comment_id, $content)
    {
        $url = env('API_URL') . 'comments/'.$comment_id;
        $ch = curl_init($url);
        $data = array(
            'id' => $comment_id,
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
