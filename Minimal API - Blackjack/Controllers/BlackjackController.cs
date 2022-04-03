using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Models;
player = new Player();
dealer = new Player();

namespace Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    public class BlackjackController : ControllerBase
    {
        DbConnection db = new DbConnection();
    }
    [HttpGet($"gamestart/{{id}}")]
    public void GameStart(int id)
    {
        var GameState = db.Where(x => x.Id == id)
                          .LastOrDefault();
        if (GameState.wldp == "pending")
        {
            return GameState.Player + GameState.Dealer;
        }
        else
        {
            var deck = new Deck();
            deck.Shuffle();
            db.create(x => x.Id == id, x => x.Deck == deck, x => x.Wldp == "pending");
            player = db.where(x => x.Id == id).LastOrDefault
                .update(x => x.Dealer = deck.Deal(2)); //Note: Player is a list of cards
            dealer = db.where(x => x.Id == id).LastOrDefault
                .update(x => x.Dealer = deck.Deal(2)); //Note: Dealer is a list of cards
            return player + dealer;
        }

    }
    [HttpGet($"hit/{{id}}")]
    public void hit(int id)
    {
        var GameState = db.Where(x => x.Id == id)
                          .LastOrDefault();
        player = db.where(x => x.Id == id).LastOrDefault
            .update(x => x.Player = GameState.Player + deck.Deal(1));

        if (player.HandValue == 21)
        {
            db.where(x => x.Id == id).LastOrDefault
                .update(x => x.Wldp = "won");
            return "Blackjack!";
        }
        if (player.HandValue > 21)
        {
            db.where(x => x.Id == id).LastOrDefault
                .update(x => x.Wldp = "lost");
            return "Bust!";
        }

        return player.Hand + dealer.Hand;


    }
    
    [HttpGet($"stand/{{id}}")]
    public void stand(int id)
    {
        while(dealer.HandValue < 17)
        {
            dealer = db.where(x => x.Id == id).LastOrDefault
                .update(x => x.Dealer = dealer.Deal(1));
        }
        if (dealer.HandValue > 21)
        {
            db.where(x => x.Id == id).LastOrDefault
                .update(x => x.Wldp = "lost");
            return "Dealer bust!";
        }
        if (dealer.HandValue > player.HandValue)
        {
            db.where(x => x.Id == id).LastOrDefault
                .update(x => x.Wldp = "won");
            return "Dealer wins!";
        }
        if (dealer.HandValue < player.HandValue)
        {
            db.where(x => x.Id == id).LastOrDefault
                .update(x => x.Wldp = "lost");
            return "Player wins!";
        }
        if (dealer.HandValue == player.HandValue)
        {
            db.where(x => x.Id == id).LastOrDefault
                .update(x => x.Wldp = "draw");
            return "Draw!";
        }
    }
}