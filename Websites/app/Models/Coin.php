<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;
    private float $value;
    public $timestamps = false;
    //get coinsAmount
    public function getCoinsAmount($value)
    {
        return number_format($value, 2, '.', ',');
    }
    //set coinsAmount
    public function setCoinsAmount($value)
    {
        $this->attributes['coinsAmount'] = number_format($value, 2, '.', ',');
    }
}
