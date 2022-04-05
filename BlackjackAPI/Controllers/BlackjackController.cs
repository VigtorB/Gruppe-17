using System.Data.Common;
using Microsoft.AspNetCore.Mvc;
using BlackjackAPI.Models;
using MongoDB.Driver;
using BlackjackAPI.DbAccess;
using MongoDB.Bson;

namespace BlackjackAPI.Controllers
{

        
    public class BlackjackController : Controller
    {
        private readonly IConfiguration _config;
        private string gameStatus;

        public BlackjackController(IConfiguration configuration)
        {
            _config = configuration;
        }
        //api get
        [HttpGet("{id}")]
        [Route("api/blackjack/gamestart/{id}")]
        public IActionResult GameStart(int id)
        {
            DbGameAccess db = new DbGameAccess(_config);
            Game game = new Game();
            game = db.GetGame(id);
            if (gameStatus == game.GameStatus)
            {
                //return game to json
                return Ok(game);
            }
            else
            {
                var deck = new Deck();
                deck.Shuffle();
                gameStatus = "pending";
                var player = new Player();
                var dealer = new Player();
                player.Deal(deck.Deal(2));
                dealer.Deal(deck.Deal(2));
                return Ok($"{player}" + $"{dealer}");
            }

        }
    }
}