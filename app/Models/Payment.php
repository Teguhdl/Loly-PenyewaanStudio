<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'payment_type',
        'status',
        'response',
        'snap_token',
    ];

    protected $casts = [
        'response' => 'array',
    ];

    public function penalties()
    {
        return $this->hasMany(Penalty::class);
    }

    public function penalty()
    {
        return $this->hasOne(Penalty::class);
    }
}
