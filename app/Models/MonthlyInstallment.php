<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'remarks',
        'start_date',
        'terms',
        'amount',
        'remaining_months',
    ];
}
