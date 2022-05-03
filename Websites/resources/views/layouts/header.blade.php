<div class="flex flex-col justify-center h-18 py-12 bg-gray-50 sm:px-6 lg:px-8 border border-gray-300 sticky content">
    <div class="relative top-0">
        <div class="flex flex-col">
            <div class="space-y-6 center">
                <a href="{{ route('home') }}">
                    <x-logo class="w-8 h-10 text-indigo-600" />
                </a>
                <h1 class="text-sm font-extrabold tracking-wider text-center text-gray-600">
                    {{ config('app.name') }}
                </h1>

                <ul class="list-reset">
                    <li class="inline px-4">
                        <a href="{{ route('games') }}"
                            class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                            Games
                        </a>
                    </li>
                    <li class="inline px-4">
                        <a href="{{ route('blog.index') }}"
                            class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                            News
                        </a>
                    </li>
                    <li class="inline px-4">
                        <a href=""
                            class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                            General Chat
                        </a>
                    </li>
                    <li class="inline px-4">
                        <a href=""
                            class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                            About us
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="absolute top-0 right-0 mt-4 mr-4">
        @if (Route::has('login'))
            @auth
                <div class="space-x-4">
                    <div class="flex items-center space-x-4">
                        <img class="w-10 h-10 rounded-full" src="" alt="">
                        <div class="space-y-1 font-medium dark:text-gray-400">
                            <div>
                                {{ Auth::user()->username }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400" id="coins">
                                <script src="/js/ajax.js" type="text/javascript">
                                    window.onload = function() {
                                        getCoins();
                                    }
                                </script>
                                Balance: <span id="coins-value"></span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        Log out
                    </a>

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
    </div>
</div>
