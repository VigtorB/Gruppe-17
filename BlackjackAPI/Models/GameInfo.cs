namespace BlackjackAPI.Models
{
    public class GameInfo
    {
        public string? GameStatus { get; set; }
        public Card[] Player { get; set; }
        public Card[] Dealer { get; set; }
    }
}