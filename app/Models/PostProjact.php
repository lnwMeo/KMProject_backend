<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostProjact extends Model
{
    use HasFactory;

    protected $fillable = [
        'titlenameprojact',
        'titleimgprojact',
        'creatornameprojact',
        'creatorimgprojact',
        'yearcreatedprojact',
        'contentprojact'
    ];
}
