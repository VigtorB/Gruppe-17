using System;
namespace BlackjackAPI.Models
{
    public class Game
    {
        //getset
        public int PlayerId { get; set; }
        public string GameStatus { get; set; }
        public Array[] Deck { get; set; }
        public Array[] Player { get; set; }
        public Array[] Dealer { get; set; }
    }
}