<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upcoming extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie',
        'screen',
        'release_on',
        'release_off',
        'stream',
        'VVIP',
        'VIP',
        'Terraces',
        'Regular',
        'status',
    ];
}
