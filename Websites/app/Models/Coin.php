<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;
    protected $table = 'coins';
    //get balance++
    protected $fillable = [
        'coin_owner',
        'balance',
        'coin_bet'
    ];

}
