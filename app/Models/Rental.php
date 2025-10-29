<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'user_id',
        'virtual_world_id',
        'start_date',
        'end_date',
        'is_returned',
        'returned_at',
        'total_penalty',
        'payment_status',
    ];

    protected $casts = [
        'is_returned' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'returned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function virtualWorld()
    {
        return $this->belongsTo(VirtualWorld::class);
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class);
    }
}
