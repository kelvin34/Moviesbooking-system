<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screens extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen',
        'rowsleft',
        'rowscenter',
        'rowsright',
        'capacity',
        'location',
        'description',
    ];
}


