@extends('layouts.app')

@section('content')



{{$user['username']}}

{{-- add friend button --}}

@if(Auth::user()->id != $user['id'] && $isFriend['isFriend'] == 0)
<a href="{{ route('addFriend', $user['id']) }}" type="submit" class="btn btn-primary">Add Friend</a>

@endif
@if(Auth::user()->id != $user['id'] && $isFriend['isFriend'] == 1)
<a href="{{ route('addFriend', $user['id']) }}" type="submit" class="btn btn-primary">Accept Friend</a>
@endif
@if(Auth::user()->id != $user['id'] && $isFriend['isFriend'] == 2)
    <a href="{{ route('deleteFriend', $user['id']) }}" type="submit" class="btn btn-primary">Delete Friend</a>
@endif



@endsection
