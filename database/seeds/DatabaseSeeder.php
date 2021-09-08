<?php

use App\Models\Room;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Room::create([
            "roomNumber" => "11-BAN-1452",
            "price" => "5000",
            'maxPerson' => "5",
            "roomType" => "1"
        ]);



        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
