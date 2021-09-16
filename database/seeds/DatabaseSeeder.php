<?php

use App\Models\Booking;
use App\Models\Room;
use App\User;
use Carbon\Carbon;
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

        Schema::disableForeignKeyConstraints();
        \DB::table('bookings')->truncate();
        Schema::enableForeignKeyConstraints();



        Schema::disableForeignKeyConstraints();
        $date = Carbon::now()->subDay();

        for($i = 0; $i < 365; $i++){
            $date = $date->addDay();
            Booking::create([
                "reservation_date" => $date
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
