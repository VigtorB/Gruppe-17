@extends('layouts.base')

@extends('layouts.header')

@extends('layouts.sidebar')

@section('body')
    @yield('content')

    @isset($slot)
        {{ $slot }}
    @endisset
@endsection
