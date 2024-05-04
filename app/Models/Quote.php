<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Quote extends Model
{
    use HasFactory;
    protected $fillable = ['user_information'];
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function calculateTotalPrice() 
    {
        $this->load('products.options');
        $this->totalPrice = 0;

        foreach ($this->products as $product) {
            $this->totalPrice += $product->base_price;
            foreach ($product->options as $option) {
                $this->totalPrice += ($option->price * $option->item_number);
            }
        }

        return $this->totalPrice;
    }

    public static function storeQuotesInDBFromJS($data){
        DB::beginTransaction();
        try {
           
            $quote = new Quote;
            $quote->user_information = $data['user_information'];
            $quote->save();

            foreach ($data['products'] as $productData) {
                $product = Product::create([
                    'id' => $productData['id'],
                    //'name' => $productData['name'],
                    'base_price' => $productData['base_price'],
                    'quote_id' => $quote->id,
                    'created_at' => $productData['created_at'],
                    'updated_at' => $productData['updated_at'],
                ]);
            }
            foreach ($productData['options'] as $optionData) {
                Option::create([
                    'id' => $optionData['id'],
                    'name' => $optionData['name'],
                    'description' => $optionData['description'],
                    'image_url' => $optionData['image_url'],
                    'price' => $optionData['price'],
                    'item_number' => $optionData['item_number'],
                    'product_id' => $product->id,
                    'created_at' => $optionData['created_at'],
                    'updated_at' => $optionData['updated_at'],
                ]);
            }
            
            DB::commit();
            return response()->json($quote, 201);
        } catch (\Throwable $th) {
            DB::rollback();
            echo "<br> ".$th;
            return response()->json(['error' => 'quote not found'], 404);
        }
    }
}
