/* function getGame() {
fetch('http://127.0.0.1:8001/games/blackjack/startgame')
  .then(response => response.json())
  .then(data => console.log(data));
} */

function hitGame(){
    fetch('http://127.0.0.1:8001/games/blackjack/hit')
    .then(response => response.json())
    .then(data => data.playerCard)
    .then(data => document.getElementById('game').innerHTML = data);

}

function standGame(){
    fetch('http://127.0.0.1:8001/games/blackjack/stand')
    .then(response => response.json())
    .then(data => console.log(data));

}
/* $jsonGame = $result['game'];
            $game['playerCard'] = $this->returnPlayerCard($jsonGame['player']);
            $game['dealerCard'] = $this->returnDealerCard($jsonGame['dealer']);
            $game['playerValue'] =  $jsonGame['playerValue'];
            $game['dealerValue'] = $jsonGame['dealerValue'];
            $game['gameStatus'] = $jsonGame['gameStatus']; */

function getCoins(){
    fetch('http://127.0.0.1:8001/coins')
    .then(response => response.json())
    .then(data => data.balance)
    .then(data => document.getElementById('coins-value').innerHTML = data);
}


