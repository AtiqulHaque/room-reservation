<?php

namespace App\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BookingRepository.
 *
 * @package namespace App\Contracts;
 */
interface BookingRepository extends RepositoryInterface
{
    public function bookRoom(array $params = array());

    public function checkIn($roomId, $userId);

    public function checkOut($roomId, $userId);

    public function bookingDetails($bookingId);

    public function bookingDetailsByRoomId($roomId, $userId);

    public function getBookingList();
}
