<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
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
                'username' => 'admin_nongsanbaolam',
                'password' => bcrypt('qwertqwert'),
                'email' => 'quanghuy@gmail.com',
                'fullname' => 'Nông sản Bảo Lâm',
            ],
        ]);
    }
}
