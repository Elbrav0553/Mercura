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

        $totalPrice = 0;
        foreach ($this->products as $product) {
            $totalPrice += $product->base_price;
            foreach ($product->options as $option) {
                $totalPrice += ($option->price * $option->item_number);
            }
        }

        return $totalPrice;
    }

    public static function storeQuotesInDBFromJS($data)
    {
        DB::beginTransaction();
        try {

            $quote = new Quote;
            $quote->user_information = $data['user_information'];
            $quote->save();


            foreach ($data['products'] as $productData) {
                $product = new Product();
                $product->base_price = $productData['base_price'];
                $product->quote_id = $quote->id;
                $product->save();

                foreach ($productData['product_translations'] as $productData_translations) {
                    $producttranslation = new ProductTranslation();
                    $producttranslation->product_id = $product->id;
                    $producttranslation->locale = $productData_translations['locale'];
                    $producttranslation->name = $productData_translations['name'];
                    $producttranslation->save();
                }
                foreach ($productData['options'] as $optionData) {
                    $option = new Option();
                    $option->image_url = $optionData['image_url'];
                    $option->price = $optionData['price'];
                    $option->item_number = $optionData['item_number'];
                    $option->product_id = $product->id;
                    $option->created_at = $optionData['created_at'];
                    $option->updated_at = $optionData['updated_at'];
                    $option->save();

                    foreach ($optionData['optiontranslations'] as $optionData_translations) {
                        $optiontranslation = new OptionTranslation();
                        $optiontranslation->option_id = $option->id;
                        $optiontranslation->locale = $optionData_translations['locale'];
                        $optiontranslation->name = $optionData_translations['name'];
                        $optiontranslation->description = $optionData_translations['description'];
                        $optiontranslation->save();
                    }
                }
            }


            DB::commit();
            return response()->json($quote, 201);
        } catch (\Throwable $th) {
            DB::rollback();
            echo "<br> " . $th;
            return response()->json(['error' => 'quote not found'], 404);
        }
    }
}
