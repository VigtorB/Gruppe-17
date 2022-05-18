var urlGameStart = "http://127.0.0.1:8001/games/blackjack/startgame";
var urlGameStand = "http://127.0.0.1:8001/games/blackjack/stand";
var urlGameHit = "http://127.0.0.1:8001/games/blackjack/hit";
var urlGetProfile = "";
var urlGetCoins = "http://127.0.0.1:8001/coins";
var urlGetFriends = "http://127.0.0.1:8001/getfriends";
var urlGetUserAndProfile = "http://127.0.0.1:8001/getuser/";
var imageSrc = '<img src="/img/';




function getGame(value) {
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
    dealerHand.classList.add("container");
    dealerHand.id = "dealerhand";
    var dealerValue = document.createElement("div");
    dealerValue.id = "dealervalue";
    var player = document.createElement("div");
    player.classList.add("container");
    player.id = "player";
    var playerHand = document.createElement("div");
    playerHand.classList.add("container");
    playerHand.id = "playerhand";
    var playerValue = document.createElement("div");
    playerValue.id = "playerValue";
    var valueClass = "class=font-medium text-3xl ";
    var cardClass = 'class="img-responsive"';



    var url = "";
    if (value === "hit") {
        url = urlGameHit;
    }
    if (value === "stand") {
        url = urlGameStand;
    }
    if (value === "newGame" || value === "startGame") {
        url = urlGameStart;
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
                    `<img class="img-cards" ${imageSrc}deck/${dealerCard}.png" ${cardClass}>`);
                dealer.appendChild(dealerHand);
                dealerValue.innerHTML =
                    `<p ${valueClass}>dealer value = ${data.dealerValue}</p>`;
                dealer.appendChild(dealerValue);

                data.playerCard.forEach((playerCard) =>
                    playerHand.innerHTML +=
                    `<img class="img-cards" ${imageSrc}deck/${playerCard}.png" ${cardClass}>`);
                player.appendChild(playerHand);

                playerValue.innerHTML =
                    `<p ${valueClass}>player value = ${data.playerValue}</p>`;
                player.appendChild(playerValue);


                hit.innerHTML = `<button id="hit" onclick="getGame('hit')" name="hit" class="flex justify-center img-buttons">
                                ${imageSrc}buttons/button(hit).png"></button>`;
                document.getElementById("game").appendChild(hit);

                stand.innerHTML = `<button id="stand" onclick="getGame('stand')" name="stand" class="flex justify-center img-buttons">
                                    ${imageSrc}buttons/button(stand).png">
                                </button>`;
                document.getElementById("game").appendChild(stand);



                if (data.gameStatus === "pending") {
                    hit.disabled = false;
                    hit.hidden = false;
                    stand.disabled = false;
                    stand.hidden = false;
                }


                if (data.gameStatus !== "pending") {
                    hit.disabled = true;
                    hit.hidden = true;
                    stand.disabled = true;
                    stand.hidden = true;
                    newGame.innerHTML = `<button id="newGame" onclick="getGame('newGame')" this.onclick=null; name="start"
                                        class = "img-buttons">
                                        <img src="/img/buttons/button(playagain).png">
                                        </button> `;
                    document.getElementById("game").appendChild(newGame);
                    newGame.hidden = false;
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
    fetch(urlGetCoins)
        .then((response) => response.json())
        .then((data) => {
            document.getElementById("coins").innerHTML = `<p>Balance: ${data}</p>`;
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
            fetch(urlGetUserAndProfile + user)
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
    var getFriendsAndClass = `font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150 center`;
    getFriendsAndFriendRequests.id = "getfriends";

    //TODO: If(cach) der tjekker på om vennelisten er opdateret.
    fetch(urlGetFriends)
        .then((response) => response.json())
        .then(function (data) {
            if (document.getElementById("getfriends") !== null && document.getElementById("usersearchinput") !== null) {
                document.getElementById("getfriends").remove();
                document.getElementById("usersearchinput").remove();
            }
            if(data.friends === null) {
                getFriendsAndFriendRequests.innerHTML = `<p class="center">You have no friends!</p>`;
            }
            else {
            data.friends.forEach((friend) => getFriendsAndFriendRequests
                .innerHTML += `<a href="/profile/${friend}"
                                class="${getFriendsAndClass}">${friend}</a>`);
            }
            getFriendsAndFriendRequests.innerHTML += `<p class="center">---------------------------------</p>`;
            if(data.friendRequests === null) {
                getFriendsAndFriendRequests.innerHTML += `<p class="center">You have no friend requests!</p>`;
            }
            else {
            data.friendRequests.forEach((friendRequest) => getFriendsAndFriendRequests
                .innerHTML += `<a href="/profile/${friendRequest}"
                                class="${getFriendsAndClass}">${friendRequest}</a>`);
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

    var buttonFriendClass = 'class="btn btn-primary img-blackjack">';

    fetch(urlGetUserAndProfile + username)
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
                                        type="submit" ${buttonFriendClass} ${imageSrc}buttons/button(add).png"></button>`;
                document.getElementById("profileInfo").appendChild(addFriend);
            }
            else if (data.friend.isFriend === 1) {

                /* declineFriend.classList.add("");
                acceptFriend.classList.add(""); */

                acceptFriend.innerHTML = `<button id="accept"
                                             onclick='friendAction("accept", ${otherUserId})'
                                             type="submit" ${buttonFriendClass} ${imageSrc}buttons/button(accept).png">
                                             </button>`;
                declineFriend.innerHTML = `<button id= "decline"
                                            onclick='friendAction("decline", ${otherUserId})'
                                            type="submit" ${buttonFriendClass} ${imageSrc}buttons/button(decline).png">
                                            </button>`;
                document.getElementById("profileInfo").appendChild(acceptFriend);
                document.getElementById("profileInfo").appendChild(declineFriend);
            }
            else if (data.friend.isFriend === 2) {

                /* pendingFriend.classList.add(""); */
                cancelFriend.innerHTML = `<button id="cancel"
                                            onclick='friendAction("cancel", ${otherUserId})'
                                            type="submit"
                                            ${buttonFriendClass} ${imageSrc}buttons/button(cancel).png">
                                            </button>`;
                document.getElementById("profileInfo").appendChild(cancelFriend);
            }
            else if (data.friend.isFriend === 3) {

                /* deleteFriend.classList.add(""); */
                deleteFriend.innerHTML = `<button id="delete"
                                            onclick='friendAction("delete", ${otherUserId})'
                                            type="submit"
                                            ${buttonFriendClass} ${imageSrc}buttons/button(remove).png">
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
