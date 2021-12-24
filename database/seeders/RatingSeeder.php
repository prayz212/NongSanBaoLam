<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ratings = [
            [
                'star' => '4',
                'product_id' => 1
            ],
            [
                'star' => '5',
                'product_id' => 1
            ],
            [
                'star' => '4',
                'product_id' => 1
            ],
            [
                'star' => '5',
                'product_id' => 2
            ],
            [
                'star' => '4',
                'product_id' => 2
            ],
            [
                'star' => '3',
                'product_id' => 4
            ],
            [
                'star' => '5',
                'product_id' => 3
            ],
            [
                'star' => '4',
                'product_id' => 4
            ],
            [
                'star' => '4',
                'product_id' => 4
            ],
            [
                'star' => '5',
                'product_id' => 5
            ]
        ];

        DB::table('rating')->insert($ratings);
    }
}
