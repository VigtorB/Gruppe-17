using System.Data.Common;
using Microsoft.AspNetCore.Mvc;
using BlackjackAPI.Models;
using MongoDB.Driver;
using BlackjackAPI.DbAccess;
using MongoDB.Bson;

namespace BlackjackAPI.Controllers
{
    [Route("api/blackjack")]
    [ApiController]


    public class BlackjackController : Controller
    {
        //api get
        [HttpGet("{id:int}")]
        public IActionResult GameStart(int id)
        {
            DbGameAccess db = new DbGameAccess();
            Game game = new Game();
            game = db.GetGame(id);
            if (game.GameStatus == "pending")
            {
                return Ok(ReturnGame(game));
            }
            else
            {
                var deck = new Deck();
                var player = new Player();
                var dealer = new Player();
                var shflDeck = deck.Shuffle();
                game.GameStatus = "pending";
                game.Player = player.Deal(2, shflDeck);
                shflDeck = player.GetDeck;
                game.Dealer = dealer.Deal(1, shflDeck);
                shflDeck = dealer.GetDeck;
                game.PlayerId = id;
                if (player.value == 21)
                {
                    //update gamestatus
                    game.GameStatus = "blackjack";
                    db.GameStart(game.PlayerId, shflDeck, player.hand, dealer.hand, game.GameStatus);
                    return Ok(ReturnGame(game));
                }
                try
                {
                    db.GameStart(game.PlayerId, shflDeck, player.hand, dealer.hand, game.GameStatus);
                    return Ok(ReturnGame(game));
                }
                catch (Exception e)
                {
                    return BadRequest(e.Message);
                }
            }
        }
        //api get
        [HttpGet("{id:int}/hit")]
        public IActionResult Hit(int id)
        {
            DbGameAccess db = new DbGameAccess();
            Game game = new Game();
            var player = new Player();
            game = db.GetGame(id);
            if(game.GameStatus != "pending")
            {
                return BadRequest("Game is over");
            }
            game.Player = player.Hit(1, game.Deck, game.Player);
            game.Deck = player.GetDeck;
            var value = player.value;
            if (value == 21)
            {
                //update gamestatus
                game.GameStatus = "blackjack";
                db.HitGame(id, game.Deck, game.Player, game.GameStatus);
                return Ok(ReturnGame(game));
            }
            if (value > 21)
            {
                //update gamestatus
                game.GameStatus = "bust";
                db.HitGame(id, game.Deck, game.Player, game.GameStatus);
                return Ok(ReturnGame(game));
            }
            db.HitGame(id, game.Deck, game.Player, game.GameStatus);
            return Ok(ReturnGame(game));
        }

        //api get
        [HttpGet("{id:int}/stand")]
        public IActionResult Stand(int id)
        {
            DbGameAccess db = new DbGameAccess();
            Game game = new Game();
            var dealer = new Player();
            var player = new Player();
            game = db.GetGame(id);
            if(game.GameStatus != "pending")
            {
                return BadRequest("Game is over");
            }
            var playerValue = player.GetValue(game.Player);
            var dealerValue = dealer.GetValue(game.Dealer);
            while (dealerValue <= 17 && dealerValue < playerValue)
            {
                var hand = dealer.Hit(1, game.Deck, game.Dealer);
                game.Deck = dealer.GetDeck;
                game.Dealer = hand;
                dealerValue = dealer.GetValue(hand);
                db.StandGame(id, game.Deck, game.Dealer, game.GameStatus);
            }
            if (dealerValue == 21)
            {
                game.GameStatus = "dealer blackjack";
                db.StandGame(id, game.Deck, game.Dealer, game.GameStatus);
                return Ok(ReturnGame(game));
            }
            if (dealerValue > 21)
            {
                game.GameStatus = "player win";
                db.StandGame(id, game.Deck, game.Dealer, game.GameStatus);
                return Ok(ReturnGame(game));
            }
            if (dealerValue > playerValue)
            {
                game.GameStatus = "dealer win";
                db.StandGame(id, game.Deck, game.Dealer, game.GameStatus);
                return Ok(ReturnGame(game));
            }
            if (dealerValue < playerValue)
            {
                game.GameStatus = "player win";
                db.StandGame(id, game.Deck, game.Dealer, game.GameStatus);
                return Ok(ReturnGame(game));
            }
            if (dealerValue == playerValue)
            {
                game.GameStatus = "draw";
                db.StandGame(id, game.Deck, game.Dealer, game.GameStatus);
                return Ok(ReturnGame(game));
            }
            return BadRequest("Something went wrong");
        }
        public GameInfo ReturnGame(Game game)
        {
            var dealer = new Player();
            var player = new Player();
            GameInfo gameInfo = new GameInfo();
            //return game
            gameInfo.GameStatus = game.GameStatus;
            gameInfo.Player = game.Player;
            gameInfo.Dealer = game.Dealer;
            gameInfo.playerValue = player.GetValue(game.Player);
            gameInfo.dealerValue = dealer.GetValue(game.Dealer);
            return gameInfo;

        }
    }

}