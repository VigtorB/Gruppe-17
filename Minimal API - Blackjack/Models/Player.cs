using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace Models
{
    public class Player
    {
        public List<Card> Hand { get; set; }
        public int HandValue()
        {
            int value = 0;
            foreach (var card in Hand)
            {
                if(card.Rank == 1 && value + 11 <= 21)
                {
                    value += 11;
                }
                else if(card.Rank >= 10)
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
    }
}