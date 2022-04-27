@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="center-block img-blackjack">
            <img src="1_of_diamonds.png">
        <a href="{{ route('blackjack.start') }}"
                class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                Blackjack
            </a>
        </div>
        <div class="mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">
                        {{ $result ?? '' }}
                </strong>
            </div>
        </div>
    </div>
@endsection
