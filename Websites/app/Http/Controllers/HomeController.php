<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(){
        return view('welcome');
    }

    public function profilePage()
    {
        return view('profile.profile');
    }
    public function userProfilePage()
    {
        return view('profile.userprofile');
    }
    public function editProfilePage()
    {
        return view('profile.settings.editprofile');
    }
}
