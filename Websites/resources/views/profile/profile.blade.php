@extends('layouts.app')

@section('content')



{{-- add friend button --}}

{{-- @if(Auth::user()->id != $user['id'] && $isFriend['isFriend'] == 0)
<a href="{{ route('addFriend', $user['id']) }}" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(add).png"></a>

@endif
@if(Auth::user()->id != $user['id'] && $isFriend['isFriend'] == 1)
<a href="{{ route('addFriend', $user['id']) }}" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(accept).png"></a>
<a href="{{ route('deleteFriend', $user['id']) }}" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(decline).png"></a>

@endif
@if(Auth::user()->id != $user['id'] && $isFriend['isFriend'] == 2)
Pending friend
<a href="{{ route('deleteFriend', $user['id']) }}" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(cancel).png"></a>
@endif
@if(Auth::user()->id != $user['id'] && $isFriend['isFriend'] == 3)
    <a href="{{ route('deleteFriend', $user['id']) }}" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(remove).png"></a>
@endif --}}
<div></div>
<div id="otheruser" class="hidden">{{ $username }}</div>
<div id="profile"></div>
<div id="commentsection"></div>
<script src="/js/ajax.js"></script>
<script>getProfile()</script>
<script></script>
@endsection
