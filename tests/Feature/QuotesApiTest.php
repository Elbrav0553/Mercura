<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\ProductSeeder;
use Database\Seeders\OptionSeeder;
use Database\Seeders\OptionTranslationsSeeder;
use Database\Seeders\QuoteSeeder;
use Database\Seeders\ProductTranslationsSeeder;
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
        $this->seed(ProductTranslationsSeeder::class);
        $this->seed(OptionTranslationsSeeder::class);
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
                "id" => 1,
                "user_information" => "Marc",
                "created_at" => null,
                "updated_at" => null
            ],
            [
                "id" => 2,
                "user_information" => "Paco",
                "created_at" => null,
                "updated_at" => null
            ],
            [
                "id" => 3,
                "user_information" => "Pepe",
                "created_at" => null,
                "updated_at" => null
            ]
        ]);
    }
    public function testGetQuoteShow()
    {
        $response = $this->get('/quotes/1');

        $response->assertStatus(200);

        $response->assertJson([
            "id" => 1,
            "user_information" => "Marc",
            "created_at" => null,
            "updated_at" => null,
            "totalPrice" => 60,
            "products" => [
                [
                    "id" => 1,
                    "base_price" => 50,
                    "quote_id" => 1,
                    "created_at" => null,
                    "updated_at" => null,
                    "product_translations" => [
                        [
                            "id" => 1,
                            "product_id" => 1,
                            "locale" => "en",
                            "name" => "basic bicycle model"
                        ],
                        [
                            "id" => 2,
                            "product_id" => 1,
                            "locale" => "es",
                            "name" => "bici modelo básico"
                        ]
                    ],
                    "options" => [
                        [
                            "id" => 1,
                            "image_url" => null,
                            "price" => 10,
                            "item_number" => "1",
                            "product_id" => 1,
                            "created_at" => null,
                            "updated_at" => null,
                            "optiontranslations" => [
                                [
                                    "id" => 1,
                                    "option_id" => 1,
                                    "locale" => "en",
                                    "name" => "road",
                                    "description" => null
                                ],
                                [
                                    "id" => 2,
                                    "option_id" => 1,
                                    "locale" => "es",
                                    "name" => "carretera",
                                    "description" => null
                                ]
                            ]
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
                    "base_price" => 50,
                    "quote_id" => 4,
                    "created_at" => null,
                    "updated_at" => null,
                    "product_translations" => [
                        [
                            "id" => 1,
                            "product_id" => 1,
                            "locale" => "en",
                            "name" => "basic bicycle model"
                        ],
                        [
                            "id" => 2,
                            "product_id" => 1,
                            "locale" => "es",
                            "name" => "bici modelo básico"
                        ]
                    ],
                    "options" => [
                        [
                            "id" => 6,
                            "image_url" => null,
                            "price" => 10,
                            "item_number" => "1",
                            "product_id" => 4,
                            "created_at" => null,
                            "updated_at" => null,
                            "optiontranslations" => [
                                [
                                    "id" => 1,
                                    "option_id" => 1,
                                    "locale" => "en",
                                    "name" => "road",
                                    "description" => null
                                ],
                                [
                                    "id" => 2,
                                    "option_id" => 1,
                                    "locale" => "es",
                                    "name" => "carretera",
                                    "description" => null
                                ]
                            ]
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
        $response = $this->get('/quotes/' . $returnedId);
        $response->assertStatus(200);

        $this->assertEquals($data['user_information'], $response['user_information']);
        $this->assertEquals($data['totalPrice'], $response['totalPrice']);

        for ($i = 0; $i < count($data['products']); $i++) {
            $this->assertEquals($data['products'][$i]['base_price'], $response['products'][$i]['base_price']);
            $this->assertEquals($data['products'][$i]['quote_id'], $returnedId);
            for ($j = 0; $j < count($data['products'][$i]['product_translations']); $j++) {
                $this->assertEquals($data['products'][$i]['product_translations'][$j]['locale'], $response['products'][$i]['product_translations'][$j]['locale']);
                $this->assertEquals($data['products'][$i]['product_translations'][$j]['name'], $response['products'][$i]['product_translations'][$j]['name']);
            }
            for ($j = 0; $j < count($data['products'][$i]['options']); $j++) {
                $this->assertEquals($data['products'][$i]['options'][$j]['price'], $response['products'][$i]['options'][$j]['price']);
                for ($x = 0; $x < count($data['products'][$i]['options'][$j]['optiontranslations']); $x++) {
                    $this->assertEquals($data['products'][$i]['options'][$j]['optiontranslations'][$x]['locale'],$data['products'][$i]['options'][$j]['optiontranslations'][$x]['locale']);
                    $this->assertEquals($data['products'][$i]['options'][$j]['optiontranslations'][$x]['name'],$response['products'][$i]['options'][$j]['optiontranslations'][$x]['name']);
                    $this->assertEquals($data['products'][$i]['options'][$j]['optiontranslations'][$x]['description'],$response['products'][$i]['options'][$j]['optiontranslations'][$x]['description']);
                }
            }
        }
        
    }
}
