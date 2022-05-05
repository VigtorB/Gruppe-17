@extends('layouts.app')

@section('content')
    <div class="center-block" id="center">

    </div>
    <script src="/js/ajax.js"></script>
    <script>
        getGame("startGame");
    </script>
@endsection
