<?php
namespace App\Contracts\Service;


interface BookingServiceContract
{
    public function bookingList();

    public function bookRoom(array $params = array());

    public function checkIn($roomId, $userId);

    public function checkOut($roomId, $userId);

    public function getBookingDetails($bookingId);

    public function getBookingDetailsByRoomId($roomId, $userId);



}
