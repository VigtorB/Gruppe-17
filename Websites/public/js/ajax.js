//TODO: Få kanpperne til at blive smidt fra js filen ind i html, i stedet for at knapperne er hardcoded i blade filen.
function getGame(value) {


    console.log(value);
    if (value === "hit") {
        var url = 'http://127.0.0.1:8001/games/blackjack/hit'
    }
    if (value === "stand") {
        var url = 'http://127.0.0.1:8001/games/blackjack/stand'
    }
    if (value === "newGame") {
        var url = 'http://127.0.0.1:8001/games/blackjack/startgame'
    }
    if (value === "startGame") {
        var url = 'http://127.0.0.1:8001/games/blackjack/startgame'
    }

    //TODO: 1. Få knapperne til at blive kreeret herinde. 2. Bedre løsning for at fjerne knapperne.

    fetch(url)
        .then(response => response.json())
        .then(data => {
            clearPage();
            data.dealerCard.forEach(dealerCard => document.getElementById('dealer-hand').innerHTML += `<img class="img-cards" src="/img/deck/${dealerCard}.png" class="img-responsive">`);
            data.playerCard.forEach(playerCard => document.getElementById('player-hand').innerHTML += `<img class="img-cards" src="/img/deck/${playerCard}.png" class="img-responsive">`);
            document.getElementById('player-value').innerHTML = data.playerValue;
            document.getElementById('dealer-value').innerHTML = data.dealerValue;

            document.getElementById('newGame').hidden = true;
            document.getElementById('hit').disabled = false;
            document.getElementById('hit').hidden = false;
            document.getElementById('stand').disabled = false;
            document.getElementById('stand').hidden = false;

            if (data.gameStatus != 'pending') {
                document.getElementById('hit').disabled = true;
                document.getElementById('hit').hidden = true;
                document.getElementById('stand').disabled = true;
                document.getElementById('stand').hidden = true;
                document.getElementById('newGame').hidden = false;
            }

            if (data.gameStatus === 'blackjack' || data.gameStatus === 'player win' || data.gameStatus === 'dealer bust') {
                document.getElementById('game-status').innerHTML = 'You won!';
            }
            if (data.gameStatus === 'pending') {
                document.getElementById('newGame').hidden = true;
            }
            else if (data.gameStatus === 'dealer win' || data.gameStatus === 'bust' || data.gameStatus === 'dealer blackjack') {
                document.getElementById('game-status').innerHTML = 'You lost!';
            }
            else if (data.gameStatus === 'draw') {
                document.getElementById('game-status').innerHTML = 'Draw!';
            }
        })
}



function clearPage() {
    document.getElementById('player-hand').innerHTML = '';
    document.getElementById('dealer-hand').innerHTML = '';
}


function getCoins() {
    fetch('http://127.0.0.1:8001/coins')
        .then(response => response.json())
        .then(data => data)
        .then(data => document.getElementById('coins-value').innerHTML = data)
}

function getFriends() {
    fetch('http://127.0.0.1:8001/getfriends')
        .then(response => response.json())
        .then(data => {
            if (document.getElementById('getfriends') != null) {
                document.getElementById('getfriends').remove();
            }
            var getFriendsAndFriendRequests = document.createElement('div');
            getFriendsAndFriendRequests.id = 'getfriends';
            data.friends.forEach(friend => getFriendsAndFriendRequests
                .innerHTML += `<a href="/profile/${friend}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150 center">${friend}</a>`)
                getFriendsAndFriendRequests.innerHTML += `<p>-----------------------------</p>`
                data.friendRequests.forEach(friendRequest => getFriendsAndFriendRequests
                .innerHTML += `<a href="/profile/${friendRequest}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150 center">${friendRequest}</a>`)
                document.getElementById('sidebar').appendChild(getFriendsAndFriendRequests);
            })
}


function getProfile() {

    var username = document.getElementById('otheruser').textContent;
    fetch('http://127.0.0.1:8001/getuser/' + username)
        .then(response => response.json())
        .then(data => {
            var otherUserId = data.user.id;
            if (document.getElementById('profileInfo') != null) {
                document.getElementById('profileInfo').remove();
            }

            var profile = document.createElement("div");
            /* profile.classList.add(""); */
            profile.id = "profileInfo";
            profile.innerHTML += `<span class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">${data.user.username}</span>`;

            document.body.appendChild(profile);


            if (data.isFriend === 0) {
                /* <a href="{{ route('addFriend', $user['id']) }}" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(add).png"></a> */
                var addFriend = document.createElement("div");
                /* addFriend.classList.add(""); */
                addFriend.innerHTML = `<button id="add" onclick="friendAction('add', ${otherUserId})" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(add).png"></button>`;
                document.getElementById('profileInfo').appendChild(addFriend);
            }
            else if (data.isFriend === 1) {
                var declineFriend = document.createElement("div");
                var acceptFriend = document.createElement("div");
                /* declineFriend.classList.add("");
                acceptFriend.classList.add(""); */

                acceptFriend.innerHTML = `<button id="accept" onclick="friendAction('accept', ${otherUserId})" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(accept).png"></button>`;
                declineFriend.innerHTML = `<button id= "decline" onclick="friendAction('decline', ${otherUserId})" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(decline).png"></button>`;
                document.getElementById('profileInfo').appendChild(acceptFriend);
                document.getElementById('profileInfo').appendChild(declineFriend);


                /* <a href="{{ route('addFriend', $user['id']) }}" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(accept).png"></a>
                <a href="{{ route('deleteFriend', $user['id']) }}" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(decline).png"></a> */
            }
            else if (data.isFriend === 2) {
                var cancelFriend = document.createElement("div");
                /* pendingFriend.classList.add(""); */
                cancelFriend.innerHTML = `<button id="cancel" onclick="friendAction('cancel', ${otherUserId})" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(cancel).png"></button>`;
                document.getElementById('profileInfo').appendChild(cancelFriend);
                /* <a href="{{ route('deleteFriend', $user['id']) }}" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(cancel).png"></a> */
            }
            else if (data.isFriend === 3) {
                var deleteFriend = document.createElement("div");
                /* deleteFriend.classList.add(""); */
                deleteFriend.innerHTML = `<button id="delete" onclick="friendAction('delete', ${otherUserId})" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(remove).png"></button>`;
                /* <a href="{{ route('deleteFriend', $user['id']) }}" type="submit" class="btn btn-primary img-blackjack"><img src="/img/buttons/button(remove).png"></a> */
                document.getElementById('profileInfo').appendChild(deleteFriend);
            }
            /* var fuckface = data.user; */
            /* document.createElement('div').innerHTML = `<div class="flex flex-col justify-center items-center">${username}</div>`; */

        }
        )
}
function friendAction(action, otherUserId) {
    if (action === 'add') {
        fetch('/profile/' + otherUserId + '/addfriend')
            .then(response => response.json())
            .then(data => {
                if (data.success === true) {
                    alert('Friend request sent!');
                }
                else {
                    alert('Friend already requested');
                }
            })
    }


    if (action === 'accept') {
        fetch('/profile/' + otherUserId + '/addfriend')
            .then(response => response.json())
            .then(data => {
                if (data.success === true) {
                    alert('Friend request accepted!');
                }
                else {
                    alert('Friend already accepted');
                }
            })
    }
    if (action === 'cancel') {
        fetch('/profile/' + otherUserId + '/deletefriend')
            .then(response => response.json())
            .then(data => {
                if (data.success === true) {
                    alert('Friend request cancelled!');
                }
                else {
                    alert('Friend request already cancelled');
                }
            })
    }

    if (action === 'decline') {
        fetch('/profile/' + otherUserId + '/deletefriend')
            .then(response => response.json())
            .then(data => {
                if (data.success === true) {
                    alert('Friend request declined!');
                }
                else {
                    alert('Friend request already declined');
                }

            })

    }
    if (action === 'delete') {
        fetch('/profile/' + otherUserId + '/deletefriend')
            .then(response => response.json())
            .then(data => {
                if (data.success === 'true') {
                    alert('Friend removed!');
                }
                else {
                    alert('Friend already removed');
                }
            })

    }
    getProfile();
    getFriends();
}

