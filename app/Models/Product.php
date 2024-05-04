<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'base_price', 'quote_id'];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
    public function options()
    {
        return $this->hasMany(Option::class);
    }
    
}
