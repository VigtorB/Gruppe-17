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
                    db.UpdateGameStatus(id, "blackjack");
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
                db.HitGame(id, game.Deck, game.Player);
                //TODO: ÆNDRE ALLE DE HER METODER: TIL AT DERES STATUS BLIVER OPDATERET I HIT OG STAND I STEDET.
                db.UpdateGameStatus(id, "blackjack");
                game.GameStatus = "blackjack";
                return Ok(ReturnGame(game));
            }
            if (value > 21)
            {
                //update gamestatus
                db.HitGame(id, game.Deck, game.Player);
                db.UpdateGameStatus(id, "bust");
                game.GameStatus = "bust";
                return Ok(ReturnGame(game));
            }
            db.HitGame(id, game.Deck, game.Player);
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
            while (dealerValue <= 17)
            {
                var hand = dealer.Hit(1, game.Deck, game.Dealer);
                game.Deck = dealer.GetDeck;
                game.Dealer = hand;
                dealerValue = dealer.GetValue(hand);
                db.StandGame(id, game.Deck, game.Dealer);
            }
            if (dealerValue == 21)
            {
                db.StandGame(id, game.Deck, game.Dealer);
                db.UpdateGameStatus(id, "dealer blackjack");
                game.GameStatus = "dealer blackjack";
                return Ok(ReturnGame(game));
            }
            if (dealerValue > 21)
            {
                db.StandGame(id, game.Deck, game.Dealer);
                db.UpdateGameStatus(id, "dealer bust");
                game.GameStatus = "dealer bust";
                return Ok(ReturnGame(game));
            }
            if (dealerValue > playerValue)
            {
                db.StandGame(id, game.Deck, game.Dealer);
                db.UpdateGameStatus(id, "dealer win");
                game.GameStatus = "dealer win";
                return Ok(ReturnGame(game));
            }
            if (dealerValue < playerValue)
            {
                db.StandGame(id, game.Deck, game.Dealer);
                db.UpdateGameStatus(id, "player win");
                game.GameStatus = "player win";
                return Ok(ReturnGame(game));
            }
            if (dealerValue == playerValue)
            {
                db.StandGame(id, game.Deck, game.Dealer);
                db.UpdateGameStatus(id, "draw");
                game.GameStatus = "draw";
                return Ok(ReturnGame(game));
            }
            return Ok(ReturnGame(game));
        }
        public GameInfo ReturnGame(Game game)
        {
            GameInfo gameInfo = new GameInfo();
            //return game
            gameInfo.GameStatus = game.GameStatus;
            gameInfo.Player = game.Player;
            gameInfo.Dealer = game.Dealer;
            return gameInfo;

        }
    }

}