<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productList = [
            [
                'name' => 'Chuối',
                'description' => 'day la mo ta ve san pham',
                'price' => 120000,
                'category_id' => 1,
                'quantity' => 100,
                'sold' => 10
            ],
            [
                'name' => 'Ổi',
                'description' => 'day la mo ta ve san pham',
                'price' => 120000,
                'category_id' => 1,
                'quantity' => 100,
                'sold' => 20
            ],
            [
                'name' => 'Nho',
                'description' => 'day la mo ta ve san pham',
                'price' => 120000,
                'category_id' => 1,
                'quantity' => 100,
                'sold' => 0
            ],
            [
                'name' => 'Xoài',
                'description' => 'day la mo ta ve san pham',
                'price' => 120000,
                'category_id' => 1,
                'quantity' => 100,
                'sold' => 0
            ],
            [
                'name' => 'Dưa hấu',
                'description' => 'day la mo ta ve san pham',
                'price' => 120000,
                'category_id' => 1,
                'quantity' => 100,
                'sold' => 15
            ],
            [
                'name' => 'Dưa lưới',
                'description' => 'day la mo ta ve san pham',
                'price' => 120000,
                'category_id' => 1,
                'quantity' => 100,
                'sold' => 22
            ],
            [
                'name' => 'Đu đủ',
                'description' => 'day la mo ta ve san pham',
                'price' => 120000,
                'category_id' => 1,
                'quantity' => 100,
                'sold' => 0
            ]
        ];

        DB::table('product')->insert($productList);
    }
}
