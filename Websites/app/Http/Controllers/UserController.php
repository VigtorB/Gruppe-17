<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /*
    public function index()
    {
        $users = Http::get('https://jsonplaceholder.typicode.com/users')->json();
        return view('users.index', compact('users'));
    }
    */
    public function getUser($info)
    {
        $user = Http::get(env('API_URL') . $info)->json();
        $user = json_decode(file_get_contents('php://input'), true);
        return $user;
    }

    /*public function register($username, $email, $password)
    {
        $url = 'http://localhost:8000/api/register';
        $ch = curl_init($url);
        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => $password
        );
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode(file_get_contents('php://input'), true);
        return $result;
    }
    public function login($email, $password)
    {
        $url = 'http://localhost:8000/api/login';
        $ch = curl_init($url);
        $data = array(
            'email' => $email,
            'password' => $password
        );
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode(file_get_contents('php://input'), true);
        return $result;
    }*/
}
