<?php
namespace App\Contracts\Service;


interface BookingServiceContract
{
    public function getBookingListByMonth($startDate = null);

    public function bookRoom(array $params = array());

    public function getBookingDetails($params);
}
