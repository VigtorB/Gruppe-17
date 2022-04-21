using System;
namespace BlackjackAPI.Models
{
    public class Game
    {
        //getset
        public int PlayerId { get; set; }
        public string? GameStatus { get; set; }
        public Card[] Player { get; set; }
        public Card[] Dealer { get; set; }

        public Card[] Deck { get; set; }
    }
}