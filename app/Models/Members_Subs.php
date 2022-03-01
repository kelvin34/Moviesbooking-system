<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members_Subs extends Model
{
    use HasFactory;

    protected $fillable=[
        'member_plan',
        'member',
        'member_id',
        'paid',
        'to',
        'status',
    ];
}
