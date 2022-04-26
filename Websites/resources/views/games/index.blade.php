@extends('layouts.app')

@section('content')


<div class="container">
    <div class="center-block img-blackjack">
        <img src="storage/Blackjack_game_1.jfif">
        <a href="{{ route('blackjack.start') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
            Blackjack
        </a>
    </div>
</div>

@endsection
