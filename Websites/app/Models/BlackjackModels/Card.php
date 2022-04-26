<?php

namespace App\Models\BlackjackModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    private int $rank;
    private string $suit;

    protected $fillable = ['rank', 'suit'];

    //get rank
    public function getRank()
    {
        return $this->rank;
    }

    //set rank
    public function setRank($rank)
    {
        $this->attributes['rank'] = $rank;
    }

    //get suit
    public function getSuit()
    {
        return $this->suit;
    }

    //set suit
    public function setSuit($suit)
    {
        $this->attributes['suit'] = $suit;
    }

}
