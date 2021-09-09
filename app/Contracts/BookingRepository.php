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

    public function roomAvailabilityCheck(array $params = array());

    public function getBookingListByMonth($startDate = null);

    public function bookingDetailsById($bookingId);

}
