<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder

{
    
    private $defaultData = array(
        array('base_price' => 50, 'quote_id' => 1),
        array('base_price' => 149.99, 'quote_id' => 3),
        array('base_price' => 250, 'quote_id' => 3),
    );

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert($this->defaultData);
    }
}
