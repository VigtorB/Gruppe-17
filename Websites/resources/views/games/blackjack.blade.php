@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="center-block">
            {{-- {{ $result }} --}}
            <a href="{{ route('blackjack.hit') }}"
                class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                Hit
            </a>
        </div>
    </div>
@endsection
