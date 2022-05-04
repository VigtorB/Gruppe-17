//TODO: FIX DENNE! Lige nu tilføjer den altid de samme kort på siden. Så den gentager kortene.
function getGame(value) {
    console.log(value);
    if (value === "hit") {
        var url = 'http://127.0.0.1:8001/games/blackjack/hit'
    }
    if (value === "stand") {
        var url = 'http://127.0.0.1:8001/games/blackjack/stand'
    }

    if (value === "startGame") {
        var url = 'http://127.0.0.1:8001/games/blackjack/startgame'
    }
    fetch(url)
        .then(response => response.json())
        .then(data => {
            data.dealerCard.forEach(dealerCard => document.getElementById('dealer-hand').innerHTML += `<img class="img-cards" src="/img/deck/${dealerCard}.png" class="img-responsive">`);
            data.playerCard.forEach(playerCard => document.getElementById('player-hand').innerHTML += `<img class="img-cards" src="/img/deck/${playerCard}.png" class="img-responsive">`);
            document.getElementById('player-value').innerHTML = data.playerValue;
            document.getElementById('dealer-value').innerHTML = data.dealerValue;

            if (data.gameStatus != 'pending') {
                document.getElementsByName('hit').disabled = true;
                document.getElementsByName('stand').disabled = true;
                document.getElementsByName('start').innerHTML = `<button type="button" class="btn btn-primary" onclick="playAgain()">Play Again</button>`;
            }

            if (data.gameStatus === 'blackjack' || data.gameStatus === 'player win' || data.gameStatus === 'dealer bust') {
                document.getElementById('game-status').innerHTML = 'You won!';
            }
            if (data.gameStatus === 'pending') {
                document.getElementById('');
            }
            else if (data.gameStatus === 'dealer win' || data.gameStatus === 'bust' || data.gameStatus === 'dealer blackjack') {
                document.getElementById('game-status').innerHTML = 'You lost!';
            }
            else if (data.gameStatus === 'draw') {
                document.getElementById('game-status').innerHTML = 'Draw!';
            }
        })
}


/* function hitGame() {
    fetch('http://127.0.0.1:8001/games/blackjack/hit')
        .then(response => response.json())
        .then(data => {
            data.dealerCard.forEach(dealerCard => document.getElementById('dealer-hand').innerHTML += `<img class="img-cards" src="/img/deck/${dealerCard}.png" class="img-responsive">`);
            document.getElementById('player-value').innerHTML = data.playerValue;
            document.getElementById('dealer-value').innerHTML = data.dealerValue;
            data.playerCard.forEach(playerCard => document.getElementById('player-hand').innerHTML += `<img class="img-cards" src="/img/deck/${playerCard}.png" class="img-responsive">`);
        })
        .then(data => console.log(data))
    /* data.playerValue.forEach(playerValue => document.getElementById('player-value').innerHTML = data.playerValue);
            data.dealerValue.forEach(dealerValue => document.getElementById('dealer-value').innerHTML = data.dealerValue); */

    /* const json_data = JSON.parse(data);
    console.log(json_data);
    } */


/* function standGame() {
    fetch('http://127.0.0.1:8001/games/blackjack/stand')
        .then(response => response.json())
        .then(data => {
            data.dealerCard.forEach(dealerCard => document.getElementById('dealer-hand').innerHTML += `<img class="img-cards" src="/img/deck/${dealerCard}.png" class="img-responsive">`);
            document.getElementById('player-value').innerHTML = data.playerValue;
            document.getElementById('dealer-value').innerHTML = data.dealerValue;
            data.playerCard.forEach(playerCard => document.getElementById('player-hand').innerHTML += `<img class="img-cards" src="/img/deck/${playerCard}.png" class="img-responsive">`);
        })

} */
/* $jsonGame = $result['game'];
            $game['playerCard'] = $this->returnPlayerCard($jsonGame['player']);
            $game['dealerCard'] = $this->returnDealerCard($jsonGame['dealer']);
            $game['playerValue'] =  $jsonGame['playerValue'];
            $game['dealerValue'] = $jsonGame['dealerValue'];
            $game['gameStatus'] = $jsonGame['gameStatus']; */

function getCoins() {
    fetch('http://127.0.0.1:8001/coins')
        .then(response => response.json())
        .then(data => data)
        .then(data => document.getElementById('coins-value').innerHTML = data)
}

function getFriends() {
    fetch('http://127.0.0.1:8001/getfriends')
        .then(response => response.json())
        .then(data => data.friend)
        .then(data => {
            if(data[0] === 'friendless pig')
            { document.getElementById('friends').innerHTML = 'You have no friends!'; }
            else {
            data => data.forEach(friend => document.getElementById('friends').innerHTML += friend);
            }
        })
}

function getFriendRequests() {
    fetch('http://127.0.0.1:8001/getfriendrequests')
        .then(response => response.json())
        .then(data => console.log(data))
        .then(data => data.forEach(friend => document.getElementById('friend').innerHTML += friend))
        .then(data => console.log(data))
}


        //let htmlSegment = `<img src="${card}" alt="">`;
