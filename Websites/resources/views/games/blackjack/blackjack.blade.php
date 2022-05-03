@extends('layouts.app')

@section('content')
<script src="/js/ajax.js"></script>
        <div class="center-block">
            <script src="/js/ajax.js"></script>
            <div class="container">
                <p>Dealer Cards</p>
                <div id="dealer-hand">
                    <p id="dealer-value"></p>
                </div>
            </div>
        <div class="container">
            <p>Your Cards</p>
            <div id="player-hand">
                <p id="player-value"></p>

            </div>
        </div>

                <div class="column">

                    <button id="game-value" onclick="getGame('hit')"  name="hit"
                        class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        Hit
                    </button>
                    <button id="game-value" onclick="getGame('stand')" name="stand"
                        class="ml-4 font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        Stand
                    </button>
                    <button id="game-value" onclick="getGame()"name = "start">
                        Play Again!
                    </button>
                </div>
            <div>

            </div>
        </div>
@endsection
