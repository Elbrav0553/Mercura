<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuoteSeeder extends Seeder
{
    private $defaultData = array(
        array('user_information' => 'Marc'),
        array('user_information' => 'Paco'),
        array('user_information' => 'Pepe'),
    );

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('quotes')->insert($this->defaultData);
    }
}
