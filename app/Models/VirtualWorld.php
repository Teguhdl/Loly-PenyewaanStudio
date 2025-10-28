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
        'code',       // Kode unik untuk membedakan unit
        'description',
        'price_per_day', // jika ingin terintegrasi payment nanti
        'status'       // misal: available, rented, maintenance
    ];

    /**
     * Relasi Many-to-Many dengan Category
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_virtual_world');
    }

}
