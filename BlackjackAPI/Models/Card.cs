namespace BlackjackAPI.Models
{
    public class Card
    {
        public Card(int rank, string suit)
        {
            Rank = rank;
            Suit = suit;
        }
        //get set Rank
        public int Rank { get; set; }
        //get set Suit
        public string Suit { get; set; }
    }
}