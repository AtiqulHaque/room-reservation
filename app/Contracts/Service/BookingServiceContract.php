<?php
namespace App\Contracts\Service;

interface BookingServiceContract
{
    /**
     * @param null $startDate
     * @return mixed
     */
    public function getBookingListByMonth($startDate = null);

    /**
     * @param array $params
     * @return mixed
     */
    public function bookRoom(array $params = array());

    /**
     * @param array $params
     * @return mixed
     */
    public function checkRoomAvailability(array $params = array());

    /**
     * @param $params
     * @return mixed
     */
    public function getBookingDetails($params);
}
