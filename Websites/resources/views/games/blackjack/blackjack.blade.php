@extends('layouts.app')

@section('content')
    <div class="center-block" id="center">
        <div id="gamestatus">

        </div>

    </div>
    <script src="/js/ajax.js"></script>
    <script>
        getGame("startGame");
    </script>
@endsection
