<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments = [
            [
                'name' => 'Quang Huy',
                'content' => "Sản phẩm này có giao hàng tại quận 7 không?",
                'product_id' => 1,
                'reply_to' => 0
            ],
            [
                'name' => 'Chí Vĩ',
                'content' => "Sản phẩm này có thời hạn sử dụng bao lây vậy shop?",
                'product_id' => 1,
                'reply_to' => 0
            ],
            [
                'name' => 'Nông sản Bảo Lâm',
                'content' => "Dạ shop có ship bạn nhé. Phí giao hàng là 25k",
                'product_id' => 1,
                'reply_to' => 1
            ],
            [
                'name' => 'Nông sản Bảo Lâm',
                'content' => "Sản phẩm bên shop có thời hạn sử dụng 7 ngày kể từ ngày giao hàng nhé Vĩ",
                'product_id' => 1,
                'reply_to' => 2
            ]
        ];

        DB::table('comment')->insert($comments);
    }
}
