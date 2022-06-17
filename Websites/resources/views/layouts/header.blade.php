<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <x-logo class="w-8 h-10 text-indigo-600" />
    <a class="navbar-brand font-medium fw-bold">Online Gaming Platform</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigationbar"
        aria-controls="navigationbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse center" id="navigationbar">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link text-black fw-bold" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black fw-bold" href="{{ route('games') }}">Games</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black fw-bold" href="{{ route('store') }}">Store</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled fw-bold" href="#">Disabled</a>
            </li>
        </ul>
    </div>

    @if (Route::has('login'))
        @auth
            <div class="space-x-4">
                <div class="flex align-items-center space-x-4">
                    <img class="w-10 h-10 rounded-full" src="/img/logo/logoprofilepicture.png" alt="">
                    <div class="space-y-1 font-medium dark:text-gray-400">
                        <div id="myuser-id" class="hidden">
                            {{ Auth::user()->id }}
                        </div>
                        <a href="{{ route('profile', $username = Auth::user()->username) }}" id="username"
                            class="fw-bold">
                            {{ Auth::user()->username }}
                        </a>
                        <div class="text-sm dark:text-gray-400 fw-bold" id="coins">
                        </div>
                        <button href="{{ route('logout') }}" type="button"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="btn btn-primary">
                            Log out
                        </button>
                    </div>
                </div>


                <a href=""></a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Log
                    in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Register</a>
                @endif
            @endauth
        </div>
    @endif
</nav>
<script src="/js/ajax.js"></script>
