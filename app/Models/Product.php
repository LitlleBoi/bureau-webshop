<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_nl',
        'category',
        'description',
        'image',
        'colors',
        'sizes',
        'available',
        'tag',
    ];

    protected $casts = [
        'colors' => 'array',
        'sizes' => 'array',
        'available' => 'boolean',
    ];

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }
}
