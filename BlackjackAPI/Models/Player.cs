namespace BlackjackAPI.Models
{
    public class Player
    {
        public Card[] hand { get; set; }
        public int HandValue()
        {
            int value = 0;
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

        public Card[] Deal(int n)
        {
            Card[] hand = new Deck().Deal(n);
            return hand;
        }
    }
}