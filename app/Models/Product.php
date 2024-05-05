<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['base_price', 'quote_id'];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
    public function ProductTranslations()
    {
        return $this->hasMany(ProductTranslation::class);
    }
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public static function getProductFormDB($product_id, $language){
        if ($language) {
            return Product::getProductFormDBWithLanguage($product_id, $language);
        }else{
            return Product::getProductFormDBWithOutLanguage($product_id);
        }
        
    }
    public static function getProductFormDBWithLanguage($product_id, $language){
        
        return Product::with(
            ['ProductTranslations' => function ($query) use ($language) 
                {
                    $query->where('locale', $language)->select('product_id', 'name');
                }, 
                'options.OptionTranslations' => function ($query) use ($language) 
                {
                    $query->where('locale', $language)->select('option_id', 'name', 'description');
                }
            ]
        )->find($product_id);
    }
    public static function getProductFormDBWithOutLanguage($product_id){
        return Product::with(['ProductTranslations','options.OptionTranslations'])->find($product_id);
    }
    
    /*
        if ($product->ProductTranslations->isNotEmpty()) {
            $product->name = $product->ProductTranslations->first()->name;
            unset($product->ProductTranslations);
        }
    */
}
