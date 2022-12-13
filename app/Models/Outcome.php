<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'item',
        'quantity',
        'price',
        'desc',
        //user_id one to many
    ];
}
