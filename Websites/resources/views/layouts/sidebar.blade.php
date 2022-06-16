@if (Route::has('login'))
    {{-- <div class="absolute top-0 right-0 mt-sidebar border border-gray-300">
        <h2 class="text-3xl font-semibold text-center text-blue-600">Friend list</h2>
        <div id="sidebar" class="flex flex-col justify-between mt-4">

        </div>
    </div> --}}
    <div class="position-absolute d-flex flex-column align-items-stretch flex-shrink-0 bg-white mt-sidebar right-0 border" style="width: 300px;">
    <div class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
      <span class="fs-5 fw-semibold center">Friendlist</span>
    </div>
    <div class="center" id="usersearch">
    <input type="text" id="usersearchinput" placeholder="Search for a user..." onclick="searchUser()">
    </div>
        <div class="list-group list-group-flush border-bottom scrollarea mb-5" id="friendlist">

        </div>
  </div>
    <script src="/js/ajax.js"></script>
@endif
