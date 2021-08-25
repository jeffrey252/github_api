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

    public function format()
    {
        $this->amount /= 100;

        $origin = new \DateTime($this->start_date);
        $target = new \DateTime();
        $interval = $origin->diff($target);
        $this->remaining_months = $this->terms - ($interval->m + ($interval->y * 12)) - 1;
        
        return $this;
    }
}
