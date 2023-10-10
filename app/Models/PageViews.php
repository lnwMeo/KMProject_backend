<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageViews extends Model
{
    // use HasFactory;
    // protected $table = 'page_views';
    protected $fillable = ['ip_address'];
}
