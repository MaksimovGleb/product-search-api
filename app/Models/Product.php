<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = ['name', 'price', 'category_id', 'in_stock', 'rating'];

    protected $casts = [
        'in_stock' => 'boolean',
        'price' => 'decimal:2',
        'rating' => 'float',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
