@extends('layouts.app')

@section('content')
@isset($game)


        <div class="center-block">
            <script src="/js/ajax.js"></script>
            <div class="container">
                <p>Dealer Cards</p>
                    @foreach ($game['dealerCard'] as $card)
                        <img class="img-cards" src="{{ asset('img/deck/' . $card . '.png') }}" class="img-responsive">
                    @endforeach
                </div>
                <div id="game">

                </div>
                <p>Dealer Score: {{ $game['dealerValue'] }}</p>
            <div class="container">
            <p>Your Cards</p>
            <div id="player-cards">

            </div>
                    {{-- @foreach ($game['playerCard'] as $card)
                        <img class="img-cards" src="{{ asset('img/deck/' . $card . '.png') }}" class="img-responsive">
                    @endforeach --}}
                </div>
                    <p>Your Score: {{ $game['playerValue'] }}</p>
            @if ($game['gameStatus'] == 'pending')
                <div class="column">
                    <button id="hit" onclick="hitGame()"
                        class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        Hit
                    </button>
                    <button id="stand" onclick="standGame()"
                        class="ml-4 font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        Stand
                    </button>
                </div>
            @endif
            <div>
                @if ($game['gameStatus'] != 'pending')
                    <a href="{{ route('blackjack.start') }}"
                        class="ml-4 font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        Play Again
                    </a>
                @endif
            </div>
        </div>
@endisset
@endsection
