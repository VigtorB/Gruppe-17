@extends('layouts.app')

@section('content')
        <div class="center-block">
            <div class="container">
                <p>Dealer Cards</p>
                    @foreach ($dealerCard as $card)
                        <img class="img-cards" src="{{ asset('img/deck/' . $card . '.png') }}" class="img-responsive">
                    @endforeach
                </div>
                <p>Dealer Score: {{ $dealerValue }}</p>
            <div class="container">
            <p>Your Cards</p>
                    @foreach ($playerCard as $card)
                        <img class="img-cards" src="{{ asset('img/deck/' . $card . '.png') }}" class="img-responsive">
                    @endforeach
                </div>
                    <p>Your Score: {{ $playerValue }}</p>
            @if ($gameStatus == 'pending')
                <div class="column">
                    <a href="{{ route('blackjack.hit') }}"
                        class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        Hit
                    </a>
                    <a href="{{ route('blackjack.stand') }}"
                        class="ml-4 font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        Stand
                </div>
            @endif
            <div>
                @if ($gameStatus != 'pending')
                    <a href="{{ route('blackjack.start') }}"
                        class="ml-4 font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        Play Again
                    </a>
                @endif
            </div>
        </div>
@endsection
