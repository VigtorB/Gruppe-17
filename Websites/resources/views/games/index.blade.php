@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="center-block img-blackjack">
            <a href="{{ route('blackjack') }}"
                class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                <img src="/img/buttons/button(blackjack).png">
            </a>
        </div>
    </div>
@endsection
