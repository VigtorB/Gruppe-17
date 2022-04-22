namespace BlackjackAPI.Models
{
    public class GameInfo
    {
        public int PlayerId { get; set; }
        public string? GameStatus { get; set; }
        public Card[] Player { get; set; }
        public Card[] Dealer { get; set; }
    }
}