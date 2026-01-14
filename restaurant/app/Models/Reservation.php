<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
    'name', 'gmail', 'phone', 'picture_path', 'people', 'day', 'hour',
];

}
