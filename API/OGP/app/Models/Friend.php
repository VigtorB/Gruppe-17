<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friendship';
    protected $fillable = ['user_id_fl', 'friend_id'];
}
