<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refunds extends Model
{
    use HasFactory;

    protected $fillable = [
        'by',
        'reason',
        'amount_requested',
        'amount_refunded',
        'comments',
        'resolved_on',
        'status',
    ];
}
