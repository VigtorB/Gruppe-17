<?php

namespace App\Models\BlackjackModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    public int $PlayerId;
    public string $GameStatus;
}
