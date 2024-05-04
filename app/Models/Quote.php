<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;
    protected $fillable = ['user_information'];
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    
}
