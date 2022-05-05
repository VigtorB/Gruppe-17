//TODO: Få knapperne til at blive smidt fra js filen ind i html, i stedet for at knapperne er hardcoded i blade filen.
function loadingStart(){

}


function getGame(value) {
    /*    var loading = document.createElement("div");
       loading.id = "loading";
       loading.innerHTML = `<img src="/img/logo/logo(load).gif" class="img-blackjack"/>`;
       document.getElementById("center").appendChild(loading); */


    var coins = getCoins();

    var game = document.createElement("div");
    game.id = "game";
    game.hidden = true;



    var hit = document.createElement("div");
    var stand = document.createElement("div");
    var newGame = document.createElement("div");
    var gameStatus = document.createElement("div");
    var dealer = document.createElement("div");
    dealer.classList.add("container");
    dealer.id = "dealer";
    var dealerHand = document.createElement("div");
    var dealerValue = document.createElement("div");
    var player = document.createElement("div");
    player.classList.add("container");
    player.id = "player";
    var playerHand = document.createElement("div");
    var playerValue = document.createElement("div");



    var url = "";
    if (value === "hit") {
        url = "http://127.0.0.1:8001/games/blackjack/hit";
    }
    if (value === "stand") {
        url = "http://127.0.0.1:8001/games/blackjack/stand";
    }
    if (value === "newGame" || value === "startGame") {
        url = "http://127.0.0.1:8001/games/blackjack/startgame";
    }

    //TODO: 1. Få knapperne til at blive kreeret herinde. 2. Bedre løsning for at fjerne knapperne.
        fetch(url)


            .then((response) => response.json())
            .then(function (data) {
                if(data.status ==="error") {
                    alert(data.message);
                    window.location.href = "/"; //TODO: Lav en løsning for at få brugeren tilbage til betalingsside.
                }
                if (document.getElementById("game") !== null) {
                    document.getElementById("game").remove();
                }
                document.getElementById("center").appendChild(game);
                game.appendChild(dealer);
                game.appendChild(player);

                data.dealerCard.forEach((dealerCard) =>
                    dealerHand.innerHTML +=
                    `<img class="img-cards" src="/img/deck/${dealerCard}.png"
             class="img-responsive">`);
                document.getElementById("dealer").appendChild(dealerHand);
                dealerValue.innerHTML =
                    `<p>dealer value = ${data.dealerValue}</p>`;
                document.getElementById("dealer").appendChild(dealerValue);

                data.playerCard.forEach((playerCard) =>
                    playerHand.innerHTML +=
                    `<img class="img-cards" src="/img/deck/${playerCard}.png"
             class="img-responsive">`);
                document.getElementById("player").appendChild(playerHand);

                playerValue.innerHTML =
                    `<p>player value = ${data.playerValue}</p>`;
                document.getElementById("player").appendChild(playerValue);





                hit.innerHTML = `<button id="hit" onclick="getGame('hit')" name="hit"
                                class="img-logo">
                                <img src="/img/buttons/button(hit).png"></button>`;
                document.getElementById("game").appendChild(hit);

                stand.innerHTML = `<button id="stand" onclick="getGame('stand')" name="stand"
                                class="img-logo">
                                <img src="/img/buttons/button(stand).png">
                                </button>`;
                document.getElementById("game").appendChild(stand);



                if (data.gameStatus === "pending") {
                    hit.disabled = false;
                    hit.hidden = false;
                    stand.disabled = false;
                    stand.hidden = false;
                }


                if (data.gameStatus !== "pending") {
                    newGame.innerHTML = `<button id="newGame" onclick="getGame('newGame')" this.onclick=null; name="start"
                                        class = "img-logo">
                                        <img src="/img/buttons/button(playagain).png">
                                        </button> `;
                    document.getElementById("game").appendChild(newGame);
                    newGame.hidden = false;
                    hit.disabled = true;
                    hit.hidden = true;
                    stand.disabled = true;
                    stand.hidden = true;
                    getCoins();

                    //TODO: fix if-sætninger og få siden til at vise gameStatus
                    if (data.gameStatus === "blackjack" ||
                        data.gameStatus === "player win" ||
                        data.gameStatus === "dealer bust") {
                        gameStatus.innerHTML = "You " + data.gameStatus + "!";
                    }

                    if (data.gameStatus === "dealer win" ||
                        data.gameStatus === "bust" ||
                        data.gameStatus === "dealer blackjack") {
                        gameStatus.innerHTML = "You " + data.gameStatus + "!";
                    }
                    if (data.gameStatus === "draw") {
                        gameStatus.innerHTML = "You " + data.gameStatus + "!";
                    }

                }

                //

            });
        /*         loading.remove(); */
        game.hidden = false;
}




function getCoins() {
    var coins = document.createElement("div");
    coins.id = "balance";
    fetch("http://127.0.0.1:8001/coins")
        .then((response) => response.json())
        .then((data) => {
            coins.innerHTML = `<p>Balance: ${data}</p>`;
            document.getElementById("coins").appendChild(coins)
        });
}

function getFriends() {
    var userSearch = document.createElement("div");
    userSearch.id = "usersearch";
    userSearch.innerHTML = `<input type="text" id="usersearchinput" placeholder="Search for a user...">`;


    userSearch.addEventListener("keypress", function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            var user = document.getElementById("usersearchinput").value;
            fetch("http://127.0.0.1:8001/getuser/" + user)
                .then((response) => response.json())
                .then(function (data) {
                    if(data.success === true) {
                        window.location.href = "/profile/" + user;
                }
                else {
                    alert("User not found");
                }
            });

    }
    });

    var getFriendsAndFriendRequests = document.createElement("div");
    //TODO: If(cach) der tjekker på om vennelisten er opdateret.
    fetch("http://127.0.0.1:8001/getfriends")
        .then((response) => response.json())
        .then(function (data) {
            if (document.getElementById("getfriends") !== null && document.getElementById("usersearchinput") !== null) {
                document.getElementById("getfriends").remove();
                document.getElementById("usersearchinput").remove();
            }
            getFriendsAndFriendRequests.id = "getfriends";
            if(data.friends === null) {
                getFriendsAndFriendRequests.innerHTML = `<p class="center">You have no friends!</p>`;
            }
            else {
            data.friends.forEach((friend) => getFriendsAndFriendRequests
                .innerHTML += `<a href="/profile/${friend}"
                                class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150 center">${friend}</a>`);
            }
            getFriendsAndFriendRequests.innerHTML += `<p class="center">---------------------------------</p>`;
            if(data.friendRequests === null) {
                getFriendsAndFriendRequests.innerHTML += `<p class="center">You have no friend requests!</p>`;
            }
            else {
            data.friendRequests.forEach((friendRequest) => getFriendsAndFriendRequests
                .innerHTML += `<a href="/profile/${friendRequest}"
                                class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150 center">${friendRequest}</a>`);
            }
            document.getElementById("sidebar").appendChild(userSearch);
            document.getElementById("sidebar").appendChild(getFriendsAndFriendRequests);
        });
}


function getProfile() {
    var username = document.getElementById("otheruser").textContent;
    var profile = document.createElement("div");
    var addFriend = document.createElement("div");
    var declineFriend = document.createElement("div");
    var acceptFriend = document.createElement("div");
    var cancelFriend = document.createElement("div");
    var deleteFriend = document.createElement("div");
    fetch("http://127.0.0.1:8001/getuser/" + username)
        .then((response) => response.json())
        .then(function (data) {
            var otherUserId = data.friend.user.id;
            if (document.getElementById("profileInfo") !== null) {
                document.getElementById("profileInfo").remove();
            }
            /* profile.classList.add(""); */
            profile.id = "profileInfo";
            profile.innerHTML += `<span class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150"
            >${data.friend.user.username}</span>`;

            document.body.appendChild(profile);

            if (data.friend.isFriend === 0) {

                /* addFriend.classList.add(""); */
                addFriend.innerHTML = `<button id="add"
                                        onclick='friendAction("add", ${otherUserId})'
                                        type="submit"
                                        class="btn btn-primary img-blackjack">
                                        <img src="/img/buttons/button(add).png"></button>`;
                document.getElementById("profileInfo").appendChild(addFriend);
            }
            else if (data.friend.isFriend === 1) {

                /* declineFriend.classList.add("");
                acceptFriend.classList.add(""); */

                acceptFriend.innerHTML = `<button id="accept"
                                             onclick='friendAction("accept", ${otherUserId})'
                                             type="submit" class="btn btn-primary img-blackjack">
                                             <img src="/img/buttons/button(accept).png">
                                             </button>`;
                declineFriend.innerHTML = `<button id= "decline"
                                            onclick='friendAction("decline", ${otherUserId})'
                                            type="submit"
                                            class="btn btn-primary img-blackjack">
                                            <img src="/img/buttons/button(decline).png">
                                            </button>`;
                document.getElementById("profileInfo").appendChild(acceptFriend);
                document.getElementById("profileInfo").appendChild(declineFriend);
            }
            else if (data.friend.isFriend === 2) {

                /* pendingFriend.classList.add(""); */
                cancelFriend.innerHTML = `<button id="cancel"
                                            onclick='friendAction("cancel", ${otherUserId})'
                                            type="submit"
                                            class="btn btn-primary img-blackjack">
                                            <img src="/img/buttons/button(cancel).png">
                                            </button>`;
                document.getElementById("profileInfo").appendChild(cancelFriend);
            }
            else if (data.friend.isFriend === 3) {

                /* deleteFriend.classList.add(""); */
                deleteFriend.innerHTML = `<button id="delete"
                                            onclick='friendAction("delete", ${otherUserId})'
                                            type="submit"
                                            class="btn btn-primary img-blackjack">
                                            <img src="/img/buttons/button(remove).png">
                                            </button>`;
                document.getElementById("profileInfo").appendChild(deleteFriend);
            }
            /* var fuckface = data.user; */

        });
}
function friendAction(action, otherUserId) {
    if (action === "add") {
        fetch("/profile/" + otherUserId + "/addfriend")
            .then((response) => response.json())
            .then(function (data) {
                if (data.success === true) {
                    alert("Friend request sent!");
                }
                else {
                    alert("Friend already requested");
                }
            });
    }


    if (action === "accept") {
        fetch("/profile/" + otherUserId + "/addfriend")
            .then((response) => response.json())
            .then(function (data) {
                if (data.success === true) {
                    alert("Friend request accepted!");
                }
                else {
                    alert("Friend already accepted");
                }
            });
    }
    if (action === "cancel") {
        fetch("/profile/" + otherUserId + "/deletefriend")
            .then((response) => response.json())
            .then(function (data) {
                if (data.success === true) {
                    alert("Friend request cancelled!");
                }
                else {
                    alert("Friend request already cancelled");
                }
            });
    }

    if (action === "decline") {
        fetch("/profile/" + otherUserId + "/deletefriend")
            .then((response) => response.json())
            .then(function (data) {
                if (data.success === true) {
                    alert("Friend request declined!");
                }
                else {
                    alert("Friend request already declined");
                }

            });
    }
    if (action === "delete") {
        fetch("/profile/" + otherUserId + "/deletefriend")
            .then((response) => response.json())
            .then(function (data) {
                if (data.success === true) {
                    alert("Friend removed!");
                }
                else {
                    alert("Friend already removed");
                }
            });

    }
    getProfile();
    getFriends();
}

function loadingEnd(){

}
