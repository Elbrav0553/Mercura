<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionSeeder extends Seeder
{
    private $defaultData = array(
        array('name' => 'road', 'price' => 10, 'item_number' => 1, 'product_id' => 1),
        array('name' => 'mountain', 'price' => 20, 'item_number' => 1, 'product_id' => 2),
        array('name' => 'hybrid', 'price' => 30, 'item_number' => 1, 'product_id' => 3),
        array('name' => '28-inch', 'price' => 10, 'item_number' => 2, 'product_id' => 3),
        array('name' => 'red', 'price' => 5, 'item_number' => 1, 'product_id' => 3),
    );

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('options')->insert($this->defaultData);
    }
}
