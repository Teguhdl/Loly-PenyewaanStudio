<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VirtualWorld;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function virtualWorlds()
    {
        return $this->belongsToMany(VirtualWorld::class, 'category_virtual_world');
    }
}
