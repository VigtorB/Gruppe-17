<div class="flex flex-col justify-center min-h-min py-12 bg-gray-50 sm:px-6 lg:px-8">
    <div class="absolute top-0 right-0 mt-4 mr-4">
        @if (Route::has('login'))
            @auth
                <div class="space-x-4">
                    <div class="flex items-center space-x-4">
                        <img class="w-10 h-10 rounded-full" src="/docs/images/people/profile-picture-5.jpg" alt="">
                        <div class="space-y-1 font-medium dark:text-gray-400">
                            <div>
                                {{ Auth::user()->username }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
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
