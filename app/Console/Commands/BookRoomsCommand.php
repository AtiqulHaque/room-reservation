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
     * Execute the console command.    zip \
     *
     * @return mixed
     */
    public function handle()
    {
        $firstName = $this->ask('Enter First Name');
        $lastName = $this->ask('Enter Last Name');
        $email = $this->ask('Enter Email');
        $reservation_date = $this->ask('Enter reservation date like ["2021-09-15","2021-09-16"]');
        $reservation_date = json_decode($reservation_date);

        $bookingService = \App::make(BookingServiceContract::class);

        $response = $bookingService->bookRoom([
            "first_name"       => $firstName,
            "last_name"        => $lastName,
            "email"            => $email,
            "reservation_date" => $reservation_date,
        ]);

        if (!empty($response['status']) && $response['status'] == 'success') {
            $this->info("Your room has been successfully booked, Thanks.");
        } else {
            $this->error("Something went wrong, Please try again later");
        }
        $this->line('');
        return $response;
    }
}
