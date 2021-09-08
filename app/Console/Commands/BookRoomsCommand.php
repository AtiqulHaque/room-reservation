<?php

namespace App\Console\Commands;

use App\Contracts\Service\BookingServiceContract;
use Illuminate\Console\Command;

class BookRoomsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book:rooms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Book rooms by console command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $firstName = $this->ask('First Name');
        $lastName = $this->ask('Last Name');
        $email = $this->ask('Email');
        $reservation_date = $this->ask('Reservation date');
        $reservation_date = json_decode($reservation_date);

        $bookingService = \App::make(BookingServiceContract::class);

        $response = $bookingService->bookRoom([
            "first_name" => $firstName,
            "last_name" => $lastName,
            "email" => $email,
            "reservation_date" => $reservation_date,
        ]);

        return $response;

    }
}
