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
        private string gameStatus;
        //api get
        [HttpGet("{id:int}")]
        public IActionResult GameStart(int id)
        {
            DbGameAccess db = new DbGameAccess();
            Game game = new Game();
            game = db.GetGame(id);
            if (game.GameStatus == "pending")
            {
                game.Deck = new Card[0];
                return Ok(game);
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
                    db.UpdateGameStatus(id, "blackjack");
                    game.GameStatus = "blackjack";
                    db.GameStart(game.PlayerId, shflDeck, player.hand, dealer.hand, game.GameStatus);
                    return Ok(game);
                }
                try
                {
                    db.GameStart(game.PlayerId, shflDeck, player.hand, dealer.hand, game.GameStatus);
                    return Ok(game);
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
            game.Player = player.Hit(1, game.Deck, game.Player);
            game.Deck = player.GetDeck;
            var value = player.value;
            if (value == 21)
            {
                //update gamestatus
                db.UpdateGameStatus(id, "blackjack");
                game.GameStatus = "blackjack";
                db.HitGame(id, game.Deck, game.Player);
                return Ok(game);
            }
            if (value > 21)
            {
                //update gamestatus
                db.UpdateGameStatus(id, "bust");
                game.GameStatus = "bust";
                db.HitGame(id, game.Deck, game.Player);
                return Ok(game);
            }
            db.HitGame(id, game.Deck, game.Player);
            return Ok(game);
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
            var playerValue = player.GetValue(game.Player);
            var dealerValue = dealer.GetValue(game.Dealer);
            while(dealerValue <= 17)
            {
                var hand = dealer.Hit(1, game.Deck, game.Dealer);
                game.Deck = dealer.GetDeck;
                game.Dealer = hand;
                dealerValue = dealer.GetValue(hand);
                db.StandGame(id, game.Deck, game.Dealer);
            }
            if(dealerValue == 21)
            {
                db.UpdateGameStatus(id, "dealer blackjack");
                    game.GameStatus = "dealer blackjack";
                db.StandGame(id, game.Deck, game.Dealer);
                return Ok(game);
            }
            if(dealerValue > 21)
            {
                db.UpdateGameStatus(id, "dealer bust");
                    game.GameStatus = "dealer bust";
                db.StandGame(id, game.Deck, game.Dealer);
                return Ok(game);
            }
            if(dealerValue > playerValue)
            {
                db.UpdateGameStatus(id, "dealer win");
                    game.GameStatus = "dealer win";
                db.StandGame(id, game.Deck, game.Dealer);
                return Ok(game);
            }
            if(dealerValue < playerValue)
            {
                db.UpdateGameStatus(id, "player win");
                    game.GameStatus = "player win";
                db.StandGame(id, game.Deck, game.Dealer);
                return Ok(game);
            }
            if(dealerValue == playerValue)
            {
                db.UpdateGameStatus(id, "draw");
                    game.GameStatus = "draw";
                db.StandGame(id, game.Deck, game.Dealer);
                return Ok(game);
            }
            return Ok(game);
        }
    }
}