<?php

namespace App\Http\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Coin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
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
        try{
            $this->validate([
                'username' => ['required'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'min:8', 'same:passwordConfirmation'],
            ]);

            $user = User::create([
                'email' => $this->email,
                'username' => $this->username,
                'password' => Hash::make($this->password),
            ]);

            $coin = Coin::create([
                'coin_owner' => $user->id,
                'balance' => 1000,
                'coin_bet' => 0,
            ]);

        }
        catch(\Exception $e){
            return redirect()->route('test')->with('error', $e->getMessage());
        }


        /*
        $user = $userController->register($this->username, $this->email, Hash::make($this->password));

        event(new Registered($user));
        */

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended(route('home'));
    }

    public function render()
    {
        return view('livewire.auth.register')->extends('layouts.auth');
    }
}
