<?php

namespace App\Models\BlackjackModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\BlackjackModels\Card;

class Game extends Model
{
    use HasFactory;
    public string $GameStatus;
    public string $Player;
    public string $Dealer;

}
