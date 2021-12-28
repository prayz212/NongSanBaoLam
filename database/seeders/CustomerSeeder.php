<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer')->insert([
            [
                'username' => 'quanghuy',
                'password' => bcrypt('qwertqwert'),
                'email' => 'quanghuy@gmail.com',
                'fullname' => 'Dương Quang Huy',
                'phone' => '0977026999',
                'address' => '193 Lê Trọng Tấn P.12 Q.Tân Bình'
            ],
            [
                'username' => 'chivi',
                'password' => bcrypt('qwertqwert'),
                'email' => 'chivi@gmail.com',
                'fullname' => 'Diệc Lữ Chí Vĩ',
                'phone' => '0977026888',
                'address' => '192 Lê Trọng Tấn P.12 Q.Tân Bình'
            ]
        ]);
    }
}
