using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace Models
{
    public Card(int rank, string suit)
        {
            Rank = rank;
            Suit = suit;
        }

    private readonly int rank;

    public int GetRank() => this.rank;

    private readonly string suit;

    public string GetSuit() => this.suit;
}