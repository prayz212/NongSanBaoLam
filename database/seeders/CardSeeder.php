<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cards = [
            [
                'number' => '4242424242424242',
                'cvc' => '642',
                'brand' => 'Visa',
                'date' => Carbon::parse('2023-11-25')
            ],
            [
                'number' => '4000056655665556',
                'cvc' => '749',
                'brand' => 'Visa',
                'date' => Carbon::parse('2023-05-13')
            ],
            [
                'number' => '5555555555554444',
                'cvc' => '559',
                'brand' => 'Visa',
                'date' => Carbon::parse('2022-11-04')
            ],
            [
                'number' => '2223003122003222',
                'cvc' => '395',
                'brand' => 'Mastercard',
                'date' => Carbon::parse('2023-12-02')
            ],
            [
                'number' => '5200828282828210',
                'cvc' => '281',
                'brand' => 'Mastercard',
                'date' => Carbon::parse('2023-04-20')
            ]
        ];

        DB::table('card')->insert($cards);
    }
}
