<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    public const AVAILABLE_CURRENCY_CODES = [
        'pln', 'chf', 'gbp', 'eur', 'usd',
    ];
}
