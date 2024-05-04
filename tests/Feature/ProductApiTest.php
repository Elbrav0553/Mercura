<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\ProductSeeder;
use Database\Seeders\OptionSeeder;
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
                "name" => "basic bicycle model",
                "base_price" => 50,
                "quote_id" => 1,
                "created_at" => null,
                "updated_at" => null
            ],
            [
                "id" => 2,
                "name" => "medium bicycle model",
                "base_price" => 149.99,
                "quote_id" => 3,
                "created_at" => null,
                "updated_at" => null
            ],
            [
                "id" => 3,
                "name" => "premium bicycle model",
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
            "name" => "premium bicycle model",
            "base_price" => 250,
            "quote_id" => 3,
            "created_at" => null,
            "updated_at" => null,
            "options" => [],
        ]);
    }
    public function testGetProductWithOptionsShow()
    {
        $this->seed(OptionSeeder::class);
        $response = $this->get('/product/1');

        $response->assertStatus(200);

        $response->assertJson([
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
        ]);
    }
}
