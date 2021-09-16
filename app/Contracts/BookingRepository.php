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
    /**
     * @param array $params
     * @return mixed
     */
    public function bookRoom(array $params = array());

    /**
     * @param array $params
     * @return mixed
     */
    public function roomAvailabilityCheck(array $params = array());

    /**
     * @param null $startDate
     * @return mixed
     */
    public function getBookingListByMonth($startDate = null);

    /**
     * @param $bookingId
     * @return mixed
     */
    public function bookingDetailsById($bookingId);
}
