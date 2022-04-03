namespace BlackjackAPI.Models
{
    public class Game
    {
        //getset
        public int playerid { get; set; }
        public string gameResult { get; set; }
        public Guid gameid { get; set; }
        public Deck deck { get; set; }
        public Player player { get; set; }
        public Player dealer { get; set; }
    }
}