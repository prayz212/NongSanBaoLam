<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Rau củ hữu cơ'
            ],
            [
                'name' => 'Rau củ Đà Lạt'
            ],
            [
                'name' => 'Rau củ ngoại nhập'
            ],
            [
                'name' => 'Trái cây Đà Lạt'
            ],
            [
                'name' => 'Trái cây ngoại nhập'
            ],
            [
                'name' => 'Combo sản phẩm'
            ]
        ];

        DB::table('category')->insert($categories);
    }
}
