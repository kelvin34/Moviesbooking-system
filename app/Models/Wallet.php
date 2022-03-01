<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner',
        'amount_in',
        'amount_out',
        'ticket_id',
        'description',
        'status',
    ];
}
