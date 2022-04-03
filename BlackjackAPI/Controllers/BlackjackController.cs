using System.Data.Common;
using Microsoft.AspNetCore.Mvc;
using BlackjackAPI.Models;
using MongoDB.Driver;

namespace BlackjackAPI.Controllers
{
    public class BlackjackController : Controller
    {
        private readonly IConfiguration _config;
        public BlackjackController(IConfiguration configuration)
        {
            _config = configuration;
        }

        //api get
        [HttpGet("{id}")]
        [Route("api/blackjack/gamestart/{id}")]
        public IActionResult GameStart(int id)
        {
            MongoClient db = new MongoClient(_config.GetConnectionString("BlackjackDB"));
            db.
            if (gameResult == "pending")
            {
                return Ok(gameResult); //TODO: return game info, so that you can continue your game
            }
            else
            {
                var deck = new Deck();
                deck.Shuffle();
                gameResult = "pending";
                var game_id = new Guid();
                var player = new Player();
                var dealer = new Player();
                player.Deal(deck.Deal(2));
                dealer.Deal(deck.Deal(2));
                
                /* new { id, deck, player, dealer, gameResult, game_id }; */
                return Ok($"{player}" + $"{dealer}");
            }

        }
    }
}