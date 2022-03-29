@extends('layouts.base')

@extends('layouts.header')

@section('body')
    @yield('content')

    @isset($slot)
        {{ $slot }}
    @endisset
@endsection
