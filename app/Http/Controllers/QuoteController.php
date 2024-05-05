<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Product;
use App\Models\Quote;
use App\Models\QuoteDetails;
use Illuminate\Http\Request;


class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quote::all();
        return response()->json($quotes, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->json()->all();
        
        if ($data) {
            return Quote::storeQuotesInDBFromJS($data);
        }else{
            return response()->json(['error' => 'data is missing'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $quote_id)
    {

        $quote = Quote::with([
            'products.ProductTranslations',
            'products.options.optiontranslations'

        ])->find($quote_id);
        
        $quote->totalPrice = $quote->calculateTotalPrice();

        if ($quote) {
            return response()->json($quote, 200);
        } else {
            return response()->json(['error' => 'quote not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
