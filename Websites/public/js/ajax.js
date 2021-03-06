var urlCoins = "http://127.0.0.1:8001/coins/";
var urlGetFriends = "http://127.0.0.1:8001/getfriends";
var urlGetProfile = "http://127.0.0.1:8001/getuser/";
var urlComments = "http://127.0.0.1:8001/comment/";
var imageSrc = '<img src="/img/';

function getGame(value) {
    var urlGameStart = "http://127.0.0.1:8001/games/blackjack/startgame";
    var urlGameStand = "http://127.0.0.1:8001/games/blackjack/stand";
    var urlGameHit = "http://127.0.0.1:8001/games/blackjack/hit";
    var game = document.createElement("div");
    game.id = "game";
    game.hidden = true;
    var button = document.createElement("button");
    button.classList.add("container", "px-10");
    var newGame = document.createElement("div");
    var gameStatus = document.getElementById("gamestatus");
    var dealer = document.createElement("div");
    dealer.classList.add("cardContainer");
    dealer.id = "dealer";
    var dealerHand = document.createElement("div");
    dealerHand.classList.add("cardContainer");
    dealerHand.id = "dealerhand";
    var dealerValue = document.createElement("div");
    dealerValue.id = "dealervalue";
    var player = document.createElement("div");
    player.classList.add("cardContainer");
    player.id = "player";
    var playerHand = document.createElement("div");
    playerHand.classList.add("cardContainer");
    playerHand.id = "playerhand";
    var playerValue = document.createElement("div");
    playerValue.id = "playerValue";
    var valueClass = 'class="fw-bold fs-3"';
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
            if (data.status === "error") {
                alert(data.message);
                window.location.href = "/"; //TODO: Lav en løsning for at få brugeren tilbage til betalingsside.
            }
            if (document.getElementById("game") !== null) {
                document.getElementById("game").remove();
            }
            document.getElementById("center").appendChild(game)
            game.appendChild(dealer);
            game.appendChild(player);
            game.appendChild(button);

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


            button.innerHTML += `<div class="row" id="hitandstand">
                                <div class="col-4">
                                    <button type="button" id="hit" onclick="getGame('hit')" name="hit" class="btn-lg btn-primary float-start">Hit
                                    </button>
                                </div>
                                <div class="col-4">
                                    <button type="button" id="stand" onclick="getGame('stand')" name="stand" class="btn-lg btn-primary float-end">Stand
                                    </button>
                                </div>
                            </div>
                                `;



            if (data.gameStatus === "pending") {
                document.getElementById("hitandstand").hidden = false;
                document.getElementById("hitandstand").disabled = false;
                gameStatus.hidden = true;
            }


            if (data.gameStatus !== "pending") {
                document.getElementById("hitandstand").hidden = true;
                document.getElementById("hitandstand").disabled = true;
                newGame.innerHTML = `<div class="row" id="newgamebutton">
                                        <div class="col-4">
                                        </div>
                                        <div class="col-4">
                                            <button type="button" id="newGame" onclick="getGame('newGame')" this.onclick=null; name="start"
                                                    class="btn btn-primary ml-2">New Game
                                            </button>
                                        </div>
                                    </div>`;
                document.getElementById("game").appendChild(newGame);
                newGame.hidden = false;
                gameStatus.hidden = false;
                getCoins();


                //TODO: fix if-sætninger og få siden til at vise gameStatus
                if (data.gameStatus === "blackjack" ||
                    data.gameStatus === "player win" ||
                    data.gameStatus === "dealer bust") {
                    gameStatus.innerHTML = `<h1 class="center">You won!</h1>`;
                }

                if (data.gameStatus === "dealer win" ||
                    data.gameStatus === "bust" ||
                    data.gameStatus === "dealer blackjack") {
                    gameStatus.innerHTML = `<h1 class="center">You lost!</h1>`;
                }
                if (data.gameStatus === "draw") {
                    gameStatus.innerHTML = `<h1 class="center">Draw!</h1>`;
                }

            }

        });
    /*         loading.remove(); */
    game.hidden = false;
}




function getCoins() {
    var coins = document.createElement("div");
    coins.id = "balance";
    fetch(urlCoins)
        .then((response) => response.json())
        .then((data) => {
            document.getElementById("coins").innerHTML = `<p>Balance: ${data}</p>`;
        });
}

function searchUser() {
    document.getElementById("usersearchinput").addEventListener("keydown", function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            var user = document.getElementById("usersearchinput").value;
            fetch(urlGetProfile + user)
                .then((response) => response.json())
                .then(function (data) {
                    if (data.success === true) {
                        window.location.href = "/profile/" + user;
                    }
                    else {
                        alert("User not found");
                    }
                });

        }
    });
}

function getFriends() {
    var getFriendsAndFriendRequests = document.getElementById("friendlist");

    //TODO: If(cach) der tjekker på om vennelisten er opdateret.
    fetch(urlGetFriends)
        .then((response) => response.json())
        .then(function (data) {
            if (document.getElementById("getfriends") !== null && document.getElementById("usersearchinput") !== null) {
                document.getElementById("getfriends").remove();
                document.getElementById("usersearchinput").remove();
            }
            if (data.friends === null) {
                getFriendsAndFriendRequests.innerHTML = `<p class="center">You have no friends!</p>`;
            }
            else {
                data.friends.forEach((friend) => getFriendsAndFriendRequests
                    .innerHTML += `<a href="/profile/${friend}" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
                      <div class="d-flex w-100 align-items-center justify-content-between">
                        <strong class="mb-1">${friend}</strong>
                      </div>
                      <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>`);
            };
            if (data.friendRequests === null) {
                getFriendsAndFriendRequests.innerHTML += `<p class="center">You have no friend requests!</p>`;
            }
            else {
                data.friendRequests.forEach((friendRequest) => getFriendsAndFriendRequests
                    .innerHTML += `<a href="/profile/${friendRequest}" class="list-group-item list-group-item-action friendrequests py-3 lh-tight" aria-current="true">
                      <div class="d-flex w-100 align-items-center justify-content-between">
                        <strong class="mb-1">${friendRequest}</strong>
                      </div>
                      <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>`);
            }
        });
}


function getProfile() {
    var otherUsername = document.getElementById("otheruser").textContent;
    var username = document.getElementById("username").textContent;
    var friendButtons = document.createElement("div");
    friendButtons.id = "friendbuttons";

    var url = null;

    if (otherUsername === username) {
        url = urlGetProfile;
    }
    else {
        url = urlGetProfile + otherUsername;
    }

    fetch(url)
        .then((response) => response.json())

        .then(function (data) {
            if (data.success === true) {
                var otherUserId = data.friend.user.id;
                profile.innerHTML += `<p class="fs-1 ml-2">${data.friend.user.username}</p>`;


                    if (data.friend.isFriend === 0) {
                        friendButtons.innerHTML = `<button id="add"
                                                onclick='friendAction("add", ${otherUserId}); changeFriendButton(0);'
                                                type="button" class="btn btn-success ml-2">Add Friend</button>`;
                    }
                    else if (data.friend.isFriend === 1) {

                        friendButtons.innerHTML = `<button id="accept"
                                                     onclick='friendAction("accept", ${otherUserId}); changeFriendButton(2);'
                                                     type="submit" class="btn btn-success ml-2">Accept Friend</button>
                                                    <button id= "decline"
                                                    onclick='friendAction("decline", ${otherUserId}); changeFriendButton(1);'
                                                    type="submit" class="btn btn-warning ml-2">Decline Friend Request</button>`;
                    }
                    else if (data.friend.isFriend === 2) {
                        friendButtons.innerHTML = `<button id="cancel"
                                                    onclick='friendAction("cancel", ${otherUserId}); changeFriendButton(1);'
                                                    type="submit"
                                                    class="btn btn-warning ml-2">Cancel Friend Request</button>`;
                    }
                    else if (data.friend.isFriend === 3) {

                        friendButtons.innerHTML = `<button id="delete"
                                                    onclick='friendAction("delete", ${otherUserId}); changeFriendButton(1);'
                                                    type="submit"
                                                    class="btn btn-danger ml-2">Delete Friend</button>
                                                    <script>function changeButton()</script>`;
                    }
                    profile.appendChild(friendButtons);
                }


            else {
                otherUserId = document.getElementById("myuser-id").textContent.trim();
                profile.innerHTML += `<p class="fs-1 ml-2">${username}</p>`;

            }
            profile.innerHTML += `<p id="otheruserid" class="hidden">${otherUserId}</p>`;
            getComments(otherUserId);
        });
}

function changeFriendButton(i) {
    var otherUserId = document.getElementById("otheruserid").textContent;
    var friendButtons = document.getElementById("friendbuttons");
    var i;
    if (i === 0) {
        friendButtons.innerHTML = `<button id="cancel"
                                    onclick='friendAction("cancel", ${otherUserId}); changeFriendButton(1);'
                                    type="submit"
                                    class="btn btn-warning ml-2">Cancel Friend Request</button>`;
    }
    else if (i === 1) {
        friendButtons.innerHTML = `<button id="add"
                                    onclick='friendAction("add", ${otherUserId}); changeFriendButton(0);'
                                    type="button" class="btn btn-success ml-2">Add Friend</button>`;
    }
    else if (i === 2) {
        friendButtons.innerHTML = `<button id="delete"
                                    onclick='friendAction("delete", ${otherUserId}); changeFriendButton(1);'
                                    type="submit"
                                    class="btn btn-danger ml-2">Delete Friend</button>`;
    }
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
}

function getComments(otherUserId) {
    var commentSectionHeader = document.createElement("div");
    commentSectionHeader.id = "commentSectionHeader";
    commentSectionHeader.innerHTML = `<h2>Comments</h2>`;
    document.getElementById("commentsection").appendChild(commentSectionHeader);
    var textArea = document.createElement("div");
    textArea.id = "addcomment";
    textArea.innerHTML = `<textarea id="comment" placeholder="Write a comment..." rows="3" cols="50" maxlength="255" ></textarea>`;
    var addCommentButton = document.createElement("div");
    addCommentButton.id = "addcommentbutton";
    addCommentButton.innerHTML = `<button id="addcommentbutton" onclick="addComment()" class="btn btn-success mt-2 ml-2 mb-2">Add Comment</button>`;
    document.getElementById("commentsection").appendChild(textArea);
    document.getElementById("commentsection").appendChild(addCommentButton);

    fetch(urlComments + otherUserId)
        .then((response) => response.json())
        .then(function (data) {
            var comments = document.createElement("div");
            comments.id = "comments";
            comments.className = "containerComments";
            var commentsButton = document.createElement("div");
            commentsButton.id = "commentsbutton";

            if (data.length === 0) {
                comments.innerHTML = `<p>No comments yet</p>`;
            }
            data.forEach(function (comment) {

                //date
                var createdDate = new Date(comment.created_at).toLocaleString();
                var updatedDate = new Date(comment.updated_at).toLocaleString();


                if (comment.sender_username === document.getElementById("username").textContent.trim()) {
                    comments.innerHTML +=
                        `<div class="card" style="width: 40rem;" id="${comment.id}">
                        <div class="card-body">
                        <h5 class="card-title" id="senderusername">From: ${comment.sender_username}</h5>
             <p class="card-text">${comment.content}</p>
             <h6 class="card-subtitle mt-2 text-muted">Created at: ${createdDate}</h6>
             <h6 class="card-subtitle mt-2 text-muted" id="updatedat">Updated at: ${updatedDate}</h6>
             <div id="containerbuttons" class="float-container">
                <div class= "float-child">
                    <button id="editcommentbutton" onclick="editComment(${comment.id}, '${comment.content}')" class="btn btn-warning">Edit</button>
                </div>
                <div class= "float-child">
                    <button id="deletecommentbutton" onclick="deleteComment(${comment.id})" class="btn btn-danger">Delete</button>
                </div>
            </div>
            </div>`
                }
                else if (comment.user_receiver_id === document.getElementById("myuser-id").textContent.trim()) {
                    comments.innerHTML +=
                        `<div class="card" style="width: 40rem;" id="${comment.id}">
                        <div class="card-body">
                        <h5 class="card-title" id="senderusername">From: ${comment.sender_username}</h5>
             <p class="card-text">${comment.content}</p>
             <h6 class="card-subtitle mt-2 text-muted">Created at: ${createdDate}</h6>
             <h6 class="card-subtitle mt-2 text-muted" id="updatedat">Updated at: ${updatedDate}</h6>
             <div id="containerbuttons" class="float-container">
                <div class= "float-child">
                    <button id="deletecommentbutton" onclick="deleteComment(${comment.id})" class="btn btn-danger">Delete</button>
                </div>
            </div>
            </div>`
                }
                else {
                    comments.innerHTML += `
                    <div class="card" style="width: 40rem;" id="${comment.id}">
                    <div class="card-body">
                    <h5 class="card-title" id="senderusername">From: ${comment.sender_username}</h5>
         <p class="card-text" id="commentid-${comment.id}">${comment.content}</p>
         <h6 class="card-subtitle mt-2 text-muted">Created at: ${createdDate}</h6>
         <h6 class="card-subtitle mt-2 text-muted" id="updatedat">Updated at: ${updatedDate}</h6>
        </div>
        </div>`
                }
            })

            document.getElementById("commentsection").appendChild(comments);

        })
}

async function addComment() {

    // Default options are marked with *
    var content = document.getElementById("comment").value;
    try {
        var otherUserId = document.getElementById("otheruserid").textContent;
    }
    catch (err) {
        var otherUserId = document.getElementById("myuser-id").textContent;
    }

    //post request
    const response = await fetch('http://127.0.0.1:8001/comment', {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
            'Content-Type': 'application/json'
            // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: 'follow', // manual, *follow, error
        referrer: 'no-referrer', // no-referrer, *client
        body: JSON.stringify({
            content: content,
            otherUserId: otherUserId
        }) // body data type must match "Content-Type" header
    })
    .then(response => response.json())
    .then(function (data) {
        if (data.success === true) {
            alert("Comment added!");
            var createdDate = new Date(data.comment.created_at).toLocaleString();
            var updatedDate = new Date(data.comment.updated_at).toLocaleString();
            comments.innerHTML += `<div class="card" style="width: 40rem;"  id="${data.comment.id}">
                        <div class="card-body">
                        <h5 class="card-title" id="senderusername">From: ${data.comment.sender_username}</h5>
             <p class="card-text">${data.comment.content}</p>
             <h6 class="card-subtitle mt-2 text-muted">Created at: ${createdDate}</h6>
             <h6 class="card-subtitle mt-2 text-muted" id="updatedat">Updated at: ${updatedDate}</h6>
             <div id="containerbuttons" class="float-container">
                <div class= "float-child">
                    <button id="editcommentbutton" onclick="editComment('commentid-${data.comment.id}', '${data.comment.content}')" class="btn btn-warning">Edit</button>
                </div>
                <div class= "float-child">
                    <button id="deletecommentbutton" onclick="deleteComment(${data.comment.id})" class="btn btn-danger">Delete</button>
                </div>
            </div>
            </div>`
            document.getElementById("commentsection").appendChild(comments);
        }
        else {
        alert("Comment not added!");
    }
    })

}


function editComment(comment_id, content) {
    let comment = prompt("Your comment: ", content);
    if (comment == null || comment == "" || comment == content) {
        alert("Comment not edited!");
    } else {
        //update fetch
        fetch(urlComments, {
            method: 'PUT', // *GET, POST, PUT, DELETE, etc.
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            credentials: 'same-origin', // include, *same-origin, omit
            headers: {
                'Content-Type': 'application/json'
                // 'Content-Type': 'application/x-www-form-urlencoded',
            },
            redirect: 'follow', // manual, *follow, error
            referrer: 'no-referrer', // no-referrer, *client
            body: JSON.stringify({
                comment_id: comment_id,
                content: comment
            }) // body data type must match "Content-Type" header
        })
            .then(function (response) {
                if (response.ok) {
                    alert("Comment edited!");
                    document.getElementById(comment_id).innerHTML = comment;
                }
                else {
                    alert("Comment not edited!");
                }
            }
            );
    }

}

function deleteComment(comment_id) {
    fetch(urlComments + 'delete/' + comment_id)
        .then((response) => response.json())
        .then((data) => {
            if (data.success === true) {
                alert("Comment deleted!");
                document.getElementById(comment_id).remove();
            }
            else {
                alert("Comment not deleted!");
            }
        }
        );
}

function setUpStore() {
    var storeButtons = document.getElementById("buybuttons");
    var buyContainer = document.createElement("div");
    buyContainer.className = "float-container";
    buyContainer.id = "buycontainer";

    buyContainer.innerHTML = `<button type="button" id="100" onclick="buyCoins(100)" class="btn btn-primary ml-2">Buy 100 coins</button>`
    buyContainer.innerHTML += `<button type="button" id="500" onclick="buyCoins(500)" class="btn btn-primary ml-2">Buy 500 coins</button>`
    buyContainer.innerHTML += `<button type="button" id="1000" onclick="buyCoins(1000)" class="btn btn-primary ml-2">Buy 1000 coins</button>`

    storeButtons.appendChild(buyContainer);
}

function buyCoins(amount) {
    //fetch post request
    fetch(urlCoins, {
        method: 'PUT', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
            'Content-Type': 'application/json'
            // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: 'follow', // manual, *follow, error
        referrer: 'no-referrer', // no-referrer, *client
        body: JSON.stringify({
            user_id: document.getElementById("myuser-id").textContent,
            amount: amount
        }) // body data type must match "Content-Type" header
    })
        .then(function (response) {
            if (response.ok) {
                alert("Coins bought!");
                var newCoins = "Balance: " + document.getElementById("coins").textContent + document.getElementById("amount").value;

                document.getElementById("coins").innerHTML = "Balance: " + newCoins;
            }
            else {
                alert("Coins not bought!");
            }
        }
        );
}


//TODO: LAV DENNE!
/* function coinBet() {
    let coinAmount = prompt("How many coins do you want to bet?", "");
    if (coinAmount == null || coinAmount == "" || coinAmount == 0 || coinAmount < 100) {
        alert("Bet not placed!");
    }
    else {
        var totalCoins = document.getElementById("coins").textContent;
        totalCoins = totalCoins.replace('balance: ', '');
        if(totalCoins < coinAmount) {
            alert("You don't have enough coins!");
        }
        else {
            fetch(urlGameStart, {)
        location.href = "http://127.0.0.1:8001/games/blackjack/blackjack/"
    }
} */
