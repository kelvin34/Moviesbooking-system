<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    use HasFactory;

    protected $fillable = [
        'request',
        'requested_by',
        'movie_requested',
        'movie',
        'comments',
        'status',
    ];
}
