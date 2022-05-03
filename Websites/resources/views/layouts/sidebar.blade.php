@if (Route::has('login'))
    <div class="absolute top-0 right-0 mt-sidebar border border-gray-300">
        <h2 class="text-3xl font-semibold text-center text-blue-600">Friend list</h2>
        <div class="flex flex-col justify-between mt-4">
            <script>
                window.onload = function() {
                    fetch('http://127.0.0.1:8001/getfriends')
                        .then(response => response.json())
                        .then(data => data.friend)
                        .then(data => data.forEach(friend => document.createElement('friends').innerHTML += friend))
                        .then(data => console.log(data))
                }
            </script>
            <aside>
                <ul>
                    <li>
                        <a class="flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-md " href="#">

                            <ol>
                                {{-- <span id="coins-value"></span> --}}
                        </a>
                    </li>
                </ul>
            </aside>
            <div class="friends"></div>
        </p>
        </ol>
        -----------------------------
        @isset($friendRequests)
            @foreach ($friendRequests as $item)
                <p>
                    <a href="{{ route('friendprofile', $item) }}"
                        class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150 center">
                        '{{ $item }}'
                    </a>
                </p>
            @endforeach
        @endisset
        </ol>
        </a>
        </li>
        </ul>
        </aside>
    </div>
    </div>
@endif
