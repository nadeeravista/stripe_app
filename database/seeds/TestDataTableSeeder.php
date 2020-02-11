<?php

use Illuminate\Database\Seeder;

class TestDataTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
         DB::table('products')->insert([
            'id' => 1,
            'name' => "Test Product 1",
            'quantity' => 10,
            'unit_price' => 100,
            'category'=>1,
            'availability'=>true,
        ]);
         
         DB::table('products')->insert([
            'id' => 2,
            'name' => "Test Product 2",
            'quantity' => 100,
            'unit_price' => 10.25,
            'category'=>2,
            'availability'=>true,
        ]);
    }

}
