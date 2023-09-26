<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postkm extends Model
{
    use HasFactory;

    protected $fillable = [
        'titlename',
        'titleimg',
        'creatorname',
        'creatorimg',
        'yearcreated',
        'content'
        ];
}
