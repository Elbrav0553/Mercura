<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'description', 'image_url', 'price', 'item_number', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
