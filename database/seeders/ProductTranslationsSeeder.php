<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTranslationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $defaultData = array(
        array('product_id' => 1, 'locale' => 'en', 'name' => 'basic bicycle model'),
        array('product_id' => 1, 'locale' => 'es', 'name' => 'bici modelo básico'),
        array('product_id' => 2, 'locale' => 'en', 'name' => 'medium bicycle model'),
        array('product_id' => 2, 'locale' => 'es', 'name' => 'bici modelo medio'),
        array('product_id' => 3, 'locale' => 'en', 'name' => 'premium bicycle model'),
        array('product_id' => 3, 'locale' => 'es', 'name' => 'bici modelo prémium'),
    );
    public function run(): void
    {
        DB::table('product_translations')->insert($this->defaultData);
    }
}
