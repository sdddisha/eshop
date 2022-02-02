<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aboutus extends Model
{
    use HasFactory;
    protected $fillable = [
        'h1',
        'h2',
        'h3','h4'
    ];
 }
