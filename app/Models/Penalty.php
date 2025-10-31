<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'days_overdue',
        'amount',
        'is_paid',
        'payment_id',
        'order_id',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
