
using BlackjackAPI.DbAccess;
namespace BlackjackAPI.Models
{
    public class Player
    {
        private Card[] deck;
        public int value;

        public Card[] hand { get; set; }
        
        public int HandValue()
        {
            foreach (var card in hand)
            {
                if (card.Rank == 1 && value + 11 <= 21)
                {
                    value += 11;
                }
                else if (card.Rank >= 10)
                {
                    value += 10;
                }
                else
                {
                    value += card.Rank;
                }
            }
            return value;
        }

        public Card[] Deal(int n, Card[] shflDeck, int id)
        {
            hand = shflDeck.Take(n).ToArray();
            shflDeck = shflDeck.Skip(n).ToArray();
            deck = shflDeck;
            HandValue();
            return hand;
        }
        public Card[] GetDeck
        {
            get { return deck; }
        }
    }
}