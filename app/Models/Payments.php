<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'paid_by',
        'amount',
        'client_description',
        'description',
        'paid_on',
        'status',
    ];
}
