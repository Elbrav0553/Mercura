<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\ProductSeeder;
use Database\Seeders\OptionSeeder;
use Database\Seeders\QuoteSeeder;
use Tests\TestCase;

class QuotesApiTest extends TestCase
{
    //use RefreshDatabase, WithFaker;
    use DatabaseMigrations, WithFaker;
    /**
     * setUp initial seeds
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ProductSeeder::class);
        $this->seed(OptionSeeder::class);
        $this->seed(QuoteSeeder::class);
        
    }
    /**
     * Test GET return JSON with Quotes.
     *
     * @return void
     */
    public function testGetQuotesIndex()
    {
        
        $response = $this->get('/quotes');

        $response->assertStatus(200);

        $response->assertJson([
            [
                "id"=> 1,
                "user_information"=> "Marc",
                "created_at"=> null,
                "updated_at"=> null
            ],
            [
                "id"=> 2,
                "user_information"=> "Paco",
                "created_at"=> null,
                "updated_at"=> null
            ],
            [
                "id"=> 3,
                "user_information"=> "Pepe",
                "created_at"=> null,
                "updated_at"=> null
            ]
        ]);
    }
    public function testGetQuoteShow()
    {
        $response = $this->get('/quotes/1');

        $response->assertStatus(200);

        $response->assertJson([
            "id"=> 1,
            "user_information"=> "Marc",
            "created_at"=> null,
            "updated_at"=> null,
            "totalPrice"=> 60,
            "products"=> [
                [
                    "id"=> 1,
                    "name"=> "basic bicycle model",
                    "base_price"=> 50,
                    "quote_id"=> 1,
                    "created_at"=> null,
                    "updated_at"=> null,
                    "options"=> [
                        [
                            "id"=> 1,
                            "name"=> "road",
                            "description"=> null,
                            "image_url"=> null,
                            "price"=> 10,
                            "item_number"=> "1",
                            "product_id"=> 1,
                            "created_at"=> null,
                            "updated_at"=> null
                        ]
                    ]
                ]
            ]
        ]);
    }
    public function testPostQuoteStore()
    {
        $data = [
            "user_information" => "Marc",
            "created_at" => null,
            "updated_at" => null,
            "totalPrice" => 60,
            "products" => [
                [
                    "id" => 4,
                    "name" => "basic bicycle model",
                    "base_price" => 50,
                    "quote_id" => 4,
                    "created_at" => null,
                    "updated_at" => null,
                    "options" => [
                        [
                            "id" => 6,
                            "name" => "road",
                            "description" => null,
                            "image_url" => null,
                            "price" => 10,
                            "item_number" => "1",
                            "product_id" => 4,
                            "created_at" => null,
                            "updated_at" => null
                        ]
                    ]
                ]
            ]
        ];
        $response = $this->postJson('/quotes', $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            "user_information",
            "updated_at",
            "created_at",
            "id"
        ]);
        $responseData = $response->json();
        $returnedId = $responseData['id'];
        $response = $this->get('/quotes/'.$returnedId);
        $response->assertStatus(200);
        
        $data['created_at'] = $response['created_at'];
        $data['updated_at'] = $response['updated_at'];
        
        for ($i = 0; $i < count($data['products']); $i++) {
            
            $data['products'][$i]['created_at'] = $response['products'][$i]['created_at'];
            $data['products'][$i]['updated_at'] = $response['products'][$i]['updated_at'];
            
            for ($j = 0; $j < count($data['products'][$i]['options']); $j++) {
            
                $data['products'][$i]['options'][$j]['created_at'] = $response['products'][$i]['options'][$j]['created_at'];
                $data['products'][$i]['options'][$j]['updated_at'] = $response['products'][$i]['options'][$j]['updated_at'];
            }
        }

        $response->assertJson($data);
    }
}

