@if (Route::has('login'))
    <div class="absolute top-0 right-0 mt-sidebar">
        <h2 class="text-3xl font-semibold text-center text-blue-600">Friend list</h2>
        <div class="flex flex-col justify-between mt-6">
            <form action="{{ route('addFriend') }}" method="post">
                @csrf
                <div class="items-center">
                    <input type="text" placeholder="Search..." id="friendSearch">
              </div>
                <div class="text-center bg-gray-100 ">
                    <button type="submit" @disabled($errors->isNotEmpty())>Add friend</button>
                </div>
                <aside>
                    <ul></ul>
                        <li>
                            <a class="flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-md " href="#">

                                <ol>

                                    @foreach ($friends as $item)
                                        <p>{{ $item }}</p>
                                    @endforeach
                                </ol>
                            </a>
                        </li>
                    </ul>
                </aside>
        </div>
    </div>
    </div>
@endif
