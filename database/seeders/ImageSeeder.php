<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = [
            [
                'name' => 'Hình minh hoạ sản phẩm 1',
                'url' => 'product-1.jpg',
                'product_id' => 1
            ],
            [
                'name' => 'Hình minh hoạ sản phẩm 2',
                'url' => 'product-2.jpg',
                'product_id' => 2
            ],
            [
                'name' => 'Hình minh hoạ sản phẩm 3',
                'url' => 'product-3.jpg',
                'product_id' => 3
            ],
            [
                'name' => 'Hình minh hoạ sản phẩm 4',
                'url' => 'product-4.jpg',
                'product_id' => 4
            ],
            [
                'name' => 'Hình minh hoạ sản phẩm 5',
                'url' => 'product-5.jpg',
                'product_id' => 5
            ],
            [
                'name' => 'Hình minh hoạ sản phẩm 5',
                'url' => 'product-5.jpg',
                'product_id' => 6
            ],
            [
                'name' => 'Hình minh hoạ sản phẩm 5',
                'url' => 'product-5.jpg',
                'product_id' => 7
            ],
            [
                'name' => 'Hình minh hoạ sản phẩm 1',
                'url' => 'product-5.jpg',
                'product_id' => 1
            ]
        ];

        DB::table('image')->insert($images);
    }
}
