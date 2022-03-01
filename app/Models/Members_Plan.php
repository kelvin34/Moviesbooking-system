<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members_Plan extends Model
{
    use HasFactory;

    protected $fillable=[
        'plan',
        'days',
        'amount',
        'description',
        'status',
    ];
}
