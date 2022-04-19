
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

        public Card[] Deal(int n, Card[] shflDeck)
        {
            hand = shflDeck.Take(n).ToArray();
            shflDeck = shflDeck.Skip(n).ToArray();
            deck = shflDeck;
            HandValue();
            return hand;
        }
        public Card[] Hit(int n, Card[] shflDeck, Card[] currHand)
        {
            hand = shflDeck.Take(n).ToArray();
            shflDeck = shflDeck.Skip(n).ToArray();
            deck = shflDeck;
            foreach (var card in hand)
            {
                hand = currHand.Append(card).ToArray();
            }
            HandValue();
            return hand;
        }
        public Card[] GetDeck
        {
            get { return deck; }
        }
        public int GetValue(Card[] playerHand)
        {
            var getValue = 0;
            foreach (var card in playerHand)
            {
                if (card.Rank == 1 && getValue + 11 <= 21)
                {
                    getValue += 11;
                }
                else if (card.Rank >= 10)
                {
                    getValue += 10;
                }
                else
                {
                    getValue += card.Rank;
                }
            }
            return getValue;
        }
    }
}