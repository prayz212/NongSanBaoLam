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
                'name' => 'Rau củ'
            ],
            [
                'name' => 'Trái cây'
            ],
            [
                'name' => 'Combo đóng hộp'
            ]
        ];

        DB::table('category')->insert($categories);
    }
}
