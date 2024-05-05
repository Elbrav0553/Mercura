<?php

namespace Tests\Feature;

use App\Models\OptionTranslation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\ProductSeeder;
use Database\Seeders\OptionSeeder;
use Database\Seeders\OptionTranslationsSeeder;
use Database\Seeders\ProductTranslationsSeeder;
use Tests\TestCase;

class ProductApiTest extends TestCase
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
        $this->seed(ProductTranslationsSeeder::class);
        $this->seed(OptionSeeder::class);
        $this->seed(OptionTranslationsSeeder::class);
    }
    /**
     * Test GET return JSON with Products.
     *
     * @return void
     */
    public function testGetProductIndex()
    {
        
        $response = $this->get('/product');

        $response->assertStatus(200);

        $response->assertJson([
            [
                "id" => 1,
                "base_price" => 50,
                "quote_id" => 1,
                "created_at" => null,
                "updated_at" => null
            ],
            [
                "id" => 2,
                "base_price" => 149.99,
                "quote_id" => 3,
                "created_at" => null,
                "updated_at" => null
            ],
            [
                "id" => 3,
                "base_price" => 250,
                "quote_id" => 3,
                "created_at" => null,
                "updated_at" => null
            ]
        ]);
    }
    public function testGetProductShow()
    {
        $response = $this->get('/product/3');

        $response->assertStatus(200);

        $response->assertJson([
            "id" => 3,
            "base_price" => 250,
            "quote_id" => 3,
            "created_at" => null,
            "updated_at" => null,
            "options" => [],
        ]);
    }
    public function testGetProductWithOptionsShow()
    {
        
        $response = $this->get('/product/1');

        $response->assertStatus(200);

        $response->assertJson([
            "id"=> 1,
            "base_price"=> 50,
            "quote_id"=> 1,
            "created_at"=> null,
            "updated_at"=> null,
            "product_translations"=> [
                [
                    "id"=> 1,
                    "product_id"=> 1,
                    "locale"=> "en",
                    "name"=> "basic bicycle model"
                ],
                [
                    "id"=> 2,
                    "product_id"=> 1,
                    "locale"=> "es",
                    "name"=> "bici modelo básico"
                ]
            ],
            "options"=> [
                [
                    "id"=> 1,
                    "image_url"=> null,
                    "price"=> 10,
                    "item_number"=> "1",
                    "product_id"=> 1,
                    "created_at"=> null,
                    "updated_at"=> null,
                    "option_translations"=> [
                        [
                            "id"=> 1,
                            "option_id"=> 1,
                            "locale"=> "en",
                            "name"=> "road",
                            "description"=> null
                        ],
                        [
                            "id"=> 2,
                            "option_id"=> 1,
                            "locale"=> "es",
                            "name"=> "carretera",
                            "description"=> null
                        ]
                    ]
                ]
            ]
        ]);
    }
    public function testGetProductWithOptionsShowWithLanguageEs()
    {
        
        $response = $this->get('/product/1/es');

        $response->assertStatus(200);

        $response->assertJson([
            "id"=> 1,
            "base_price"=> 50,
            "quote_id"=> 1,
            "created_at"=> null,
            "updated_at"=> null,
            "product_translations"=> [
                [
                    "product_id"=> 1,
                    "name"=> "bici modelo básico"
                ]
            ],
            "options"=> [
                [
                    "id"=> 1,
                    "image_url"=> null,
                    "price"=> 10,
                    "item_number"=> "1",
                    "product_id"=> 1,
                    "created_at"=> null,
                    "updated_at"=> null,
                    "option_translations"=> [
                        [
                            "option_id"=> 1,
                            "name"=> "carretera"
                        ]
                    ]
                ]
            ]
        ]);
    }
}
