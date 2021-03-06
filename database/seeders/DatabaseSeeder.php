<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            CategorySeeder::class,
            // ProductSeeder::class,
            // ImageSeeder::class,
            // CommentSeeder::class,
            // RatingSeeder::class,
            CustomerSeeder::class,
            CardSeeder::class,
            VoucherSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
