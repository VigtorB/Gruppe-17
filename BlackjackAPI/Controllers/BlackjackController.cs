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
            try
            {
                game = db.GetGame(id);
                if (game.GameStatus == "pending")
                {
                    return Ok(game.GameStatus);
                }
                else
                {
                    var deck = new Deck();
                    var player = new Player();
                    var dealer = new Player();
                    var shflDeck = deck.Shuffle();
                    gameStatus = "pending";
                    var playerHand = player.Deal(2, shflDeck, id);
                    shflDeck = player.GetDeck;
                    var dealerHand = dealer.Deal(1, shflDeck, id);
                    shflDeck = dealer.GetDeck;
                    if (player.value == 21)
                    {
                        //update gamestatus
                        db.UpdateGameStatus(id, "blackjack");
                        return Ok("blackjack");
                    }
                    db.GameStart(id, shflDeck, playerHand, dealerHand, gameStatus); //TODO: fix deck, playerHand and dealerHand
                    return Ok($"{playerHand}" + $"{dealerHand}");
                }
            }
            catch (Exception e)
            {
                var deck = new Deck();
                var player = new Player();
                var dealer = new Player();
                var shflDeck = deck.Shuffle();
                gameStatus = "pending";
                var playerHand = player.Deal(2, shflDeck, id);
                shflDeck = player.GetDeck;
                var dealerHand = dealer.Deal(2, shflDeck, id);
                shflDeck = dealer.GetDeck;
                if (player.value == 21)
                {
                    //update gamestatus
                    db.UpdateGameStatus(id, "blackjack");
                    return Ok("blackjack");

                }
                db.GameStart(id, shflDeck, playerHand, dealerHand, gameStatus); //TODO: fix deck, playerHand and dealerHand
                return Ok($"{playerHand}" + $"{dealerHand}");
            }

        }
        //api get
        [HttpGet("{id:int}/hit")]
        public IActionResult Hit(int id)
        {
            DbGameAccess db = new DbGameAccess();
            /* db.HitGame(id, deck, playerHand, dealerHand); */
            /* Game game = new Game();
            game = db.GetGame(id);
            if (game.GameStatus == "pending")
            {
            }
            else
            {
                return BadRequest("Game is not pending");
            } */
            return Ok("Hit");
        }

        //api get
        [HttpGet("{id:int}/stand")]
        public IActionResult Stand(int id)
        {
            DbGameAccess db = new DbGameAccess();
            db.StandGame(id);
            /* Game game = new Game();
            game = db.GetGame(id);
            if (game.GameStatus == "pending")
            {
            }
            else
            {
                return BadRequest("Game is not pending");
            } */
            return Ok("Stand");
        }
    }
}