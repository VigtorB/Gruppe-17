using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace Models
{
    public Deck() => cards =
                new[] { "Spades", "Hearts", "Clubs", "Diamonds", }
                    .SelectMany(
                        suit => Enumerable.Range(1, 13),
                        (suit, rank) => new Card(rank, suit))
                    .ToArray();
    public void Shuffle()
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
    }
    public Card[] Deal(int n)
    {
        var hand = cards.Take(n).ToArray();
        cards = cards.Skip(n).ToArray();
        return hand;
    }
}