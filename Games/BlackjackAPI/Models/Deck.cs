using BlackjackAPI.Models;
namespace BlackjackAPI.Models
{
    public class Deck
    {
        public Card[] cards;

        public Deck() => cards =
            new[] { "spades", "hearts", "clubs", "diamonds", }
                .SelectMany(
                    suit => Enumerable.Range(1, 13),
                    (suit, rank) => new Card(rank, suit))
                .ToArray();

        public Card[] Shuffle()
        {
            var rng = new Random();
            var n = cards.Length;
            while (n > 1)
            {
                n--;
                var k = rng.Next(n + 1);
                var temp = cards[k];
                cards[k] = cards[n];
                cards[n] = temp;
            }
            return cards;
            
        }
        //deal cards, update deck and return hand
        
    }

}