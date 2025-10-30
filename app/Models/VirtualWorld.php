<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Rental;
class VirtualWorld extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',  
        'price_per_day',
        'image',       // ✅ tambahkan ini
        'is_rented',
        'is_available'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_virtual_world');
    }
}
