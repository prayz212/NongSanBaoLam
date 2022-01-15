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
        DB::table('admin')->insert([
            [
                'username' => 'admin_nongsanbaolam',
                'password' => bcrypt('qwertqwert'),
                'email' => 'chivi@gmail.com',
                'fullname' => 'Nông sản Bảo Lâm',
            ],
        ]);
    }
}
