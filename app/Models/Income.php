<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'name',
        'from',
        'TypeIcome_id',
        'price',
        'desc',
    ];

    public function typeincome(){
        return $this->hasMany(TypeIncome::class, 'id', 'TypeIcome_id' );
    }
}
