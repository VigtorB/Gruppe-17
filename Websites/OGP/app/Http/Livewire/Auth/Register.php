<?php

namespace App\Http\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Coin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Register extends Component
{
    /** @var string */
    public $username = '';

    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    public function register()
    {
        $this->validate([
            'username' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'same:passwordConfirmation'],
        ]);

        //TODO: Lav denne om til at bruge store metode i \Controllers\UserController
        /* $user = User::create([
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]); */

        //register user with api route
        $response = Http::post('http://localhost:8000/api/register', [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
        ]);
        //get user id from database
        $user_id = $response->id;
        //add user id to current coin database
        $coin = new Coin;
        $coin->user_id = $user_id;
        $coin->save();

        event(new Registered($response));

        Auth::login($response, true);

        return redirect()->intended(route('home'));
    }

    public function render()
    {
        return view('livewire.auth.register')->extends('layouts.auth');
    }
}
