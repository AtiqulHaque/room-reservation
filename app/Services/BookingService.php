<?php

namespace App\Services;

use App\Contracts\BookingRepository;
use App\Contracts\Service\BookingServiceContract;
use App\Contracts\Service\UserServiceContract;
use App\Validators\BookingValidator;
use Illuminate\Support\Collection;

class BookingService implements BookingServiceContract
{
    /**
     * @var BookingRepository
     */
    private $bookingRepo;
    /**
     * @var BookingValidator
     */
    private $validator;

    /**
     * @var BookingServiceContract
     */
    private $bookService;
    /**
     * @var UserServiceContract
     */
    private $userService;

    /**
     * BookingService constructor.
     * @param BookingRepository $bookingRepo
     * @param BookingValidator $validator
     * @param UserServiceContract $userService
     */
    public function __construct(
        BookingRepository $bookingRepo,
        BookingValidator $validator,
        UserServiceContract $userService
    ) {
        $this->bookingRepo = $bookingRepo;
        $this->userService = $userService;

        $this->validator = $validator;
    }

    /**
     * @param array $params
     * @return array
     */
    public function bookRoom(array $params = array())
    {
        $requestUser = $this->userService->createOrFetchUser($params);

        if (!empty($requestUser) && $requestUser['status'] != 'success') {
            return $requestUser;
        }

        $params = array_merge($params, ['user_id' => $requestUser['data']->id]);

        $this->validator->setBookingRules();

        if (!$this->validator->with($params)->passes()) {
            return [
                'html'   => "Booking validation errors",
                'status' => 'validation-error',
                'error'  => $this->validator->errors()->messages()
            ];
        }

        $reservationDetails = $this->bookingRepo->bookRoom($params);

        $responseResult = $response = array();

        if (!empty($reservationDetails) && $reservationDetails instanceof Collection
            && $reservationDetails->count() == 0) {
            return [
                "status" => 'error',
                'data'   => $response
            ];
        }

        foreach ($reservationDetails as $eachReservation) {
            $responseResult[$eachReservation->reservation_date] = $eachReservation->reservation_date;
        }

        foreach ($params['reservation_date'] as $eachDate) {
            if (!empty($responseResult[$eachDate])) {
                $response[$eachDate] = true;
            } else {
                $response[$eachDate] = false;
            }
        }
        return [
            "status" => 'success',
            'data'   => $response
        ];
    }

    /**
     * @param $params
     * @return array
     */
    public function getBookingDetails($params)
    {
        $this->validator->setBookingDetailsRules();

        if (!$this->validator->with($params)->passes()) {
            return [
                'html'   => "Booking validation errors",
                'status' => 'validation-error',
                'error'  => $this->validator->errors()->messages()
            ];
        }


        $responseBooking = $this->bookingRepo->bookingDetailsById($params['booking_id']);

        if (!empty($responseBooking)) {
            return [
                "status" => 'success',
                'data'   => $responseBooking
            ];
        } else {
            return [
                "status" => 'error',
                'html'   => "invalid booking id"
            ];
        }
    }

    /**
     * @param null $startDate
     * @return array
     */
    public function getBookingListByMonth($startDate = null)
    {
        if ($result = $this->bookingRepo->getBookingListByMonth($startDate)) {
            return [
                "status" => 'success',
                'data'   => $this->bookingRepo->getBookingListByMonth($startDate)
            ];
        } else {
            return [
                "status" => 'error',
                'data'   => []
            ];
        }

    }

    /**
     * @param array $params
     * @return array
     */
    public function checkRoomAvailability(array $params = array())
    {
        $this->validator->setAvailabilityRules();

        if (!$this->validator->with($params)->passes()) {
            return [
                'html'   => "Booking Availability validation errors",
                'status' => 'validation-error',
                'error'  => $this->validator->errors()->messages()
            ];
        }

        $reservations = $this->bookingRepo->roomAvailabilityCheck($params);

        $isAvaLabel = true;

        foreach ($reservations as $eachReservation) {
            if($eachReservation->isBooked){
                $isAvaLabel = false;
                break;
            }
        }

        return [
            "status" => 'success',
            'data'   => ($isAvaLabel) ? "free" : "booked"
        ];
    }
}
