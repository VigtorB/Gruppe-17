@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="center-block img-blackjack">
            <a href="{{ route('blackjack') }}">
                <button type="button" onclick="{{ route('blackjack') }}" class="btn btn-primary btn-lg">
                    Blackjack
                </button>
            </a>
        </div>
    </div>
@endsection
