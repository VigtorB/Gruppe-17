@if (Route::has('login'))
    <div class="absolute top-0 right-0 mt-sidebar border border-gray-300">
        <h2 class="text-3xl font-semibold text-center text-blue-600">Friend list</h2>
        <div id="sidebar" class="flex flex-col justify-between mt-4">
            <aside>
                <ul>
                    <li>
                        <a class="flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-md " href="#">

                            <ol>
                        </a>
                    </li>
                </ul>
            </aside>
        </p>
        </ol>


        <div id="friendrequests">

        </div>
    </div>
    </div>
    <script src="/js/ajax.js"></script>
    <script>getFriends()</script>
@endif
