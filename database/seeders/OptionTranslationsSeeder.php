<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionTranslationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $defaultData = array(
        array('option_id' => 1, 'locale' => 'en', 'name' => 'road'),
        array('option_id' => 1, 'locale' => 'es', 'name' => 'carretera'),

        array('option_id' => 2, 'locale' => 'en', 'name' => 'mountain'),
        array('option_id' => 2, 'locale' => 'es', 'name' => 'montaña'),

        array('option_id' => 3, 'locale' => 'en', 'name' => 'hybrid'),
        array('option_id' => 3, 'locale' => 'es', 'name' => 'hybrida'),

        array('option_id' => 4, 'locale' => 'en', 'name' => '28-inch'),
        array('option_id' => 4, 'locale' => 'es', 'name' => '28-pulgadas'),

        array('option_id' => 5, 'locale' => 'en', 'name' => 'red'),
        array('option_id' => 5, 'locale' => 'es', 'name' => 'rojo'),
    );
    public function run(): void
    {
        DB::table('option_translations')->insert($this->defaultData);
    }
}
