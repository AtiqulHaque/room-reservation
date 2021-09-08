<?php


namespace App\Services;


use App\Contracts\BookingRepository;
use App\Contracts\Service\BookingServiceContract;
use App\Contracts\Service\RoomServiceContarct;
use App\Validators\BookingValidator;

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
     * @var RoomServiceContarct
     */
    private $roomService;
    /**
     * @var BookingServiceContract
     */
    private $bookService;

    public function __construct(BookingRepository $bookingRepo,
        BookingValidator $validator,
        RoomServiceContarct $roomService
    )
    {
        $this->bookingRepo = $bookingRepo;
        $this->roomService = $roomService;

        $this->validator = $validator;
    }

    public function bookRoom(array $params = array())
    {
        $this->validator->setBookingRules();

        if (!$this->validator->with($params)->passes()) {
            return [
                'html'   => "Booking validation errors",
                'status' => 'validation-error',
                'error'  => $this->validator->errors()->messages()
            ];
        }

        $roomDetails = $this->roomService->roomDetails($params['room_id']);

        $params = array_merge($params, ['room_number'=> $roomDetails->roomNumber]);

        $params = $this->bookingRepo->bookRoom($params);

        if(!empty($params)){
            return [
                "status" => 'success',
                'data' => $params
            ];
        } else{
            return [
                "status" => 'error',
                'data' => $params
            ];
        }
    }

    public function checkIn($roomId, $userId)
    {
        $this->validator->setCherckIn();

        if (!$this->validator->with([
            'room_id' => $roomId,
            'user_id' => $userId
        ])->passes()) {
            return [
                'html'   => "Booking validation errors",
                'status' => 'validation-error',
                'error'  => $this->validator->errors()->messages()
            ];
        }

        $response = $this->bookingRepo->checkIn($roomId, $userId);

        if(!empty($response)){
            return [
                "status" => 'success',
                'data' => $response
            ];
        } else{
            return [
                "status" => 'error',
                'data' => $response
            ];
        }
    }

    public function checkOut($roomId, $userId)
    {
        $this->validator->setCherckOut();

        if (!$this->validator->with([
            'room_id' => $roomId,
            'user_id' => $userId
        ])->passes()) {
            return [
                'html'   => "Booking validation errors",
                'status' => 'validation-error',
                'error'  => $this->validator->errors()->messages()
            ];
        }

        $details = $this->bookingRepo->bookingDetailsByRoomId($roomId, $userId);

        if(!empty($details)){
            $payment = $this->bookingRepo->find($details->id);
            if(empty($payment) ){
                return [
                    "status" => 'error',
                    'html' => "Need to pay the Payment "
                ];
            }

            if($payment->isFullPayment == 0){
                return [
                    "status" => 'error',
                    'html' => "Need to pay the pertial Payment"
                ];
            }
        }

        $response = $this->bookingRepo->checkOut($roomId, $userId);

        if(!empty($response)){
            return [
                "status" => 'success',
                'data' => $response
            ];
        } else{
            return [
                "status" => 'success',
                'data' => $response
            ];
        }
    }

    public function getBookingDetails($bookingId)
    {

        $responseBooking = $this->bookingRepo->bookingDetails($bookingId);

        if(!empty($responseBooking)){
            return [
                "status" => 'success',
                'data' => $responseBooking
            ];
        } else{
            return [
                "status" => 'error',
                'html' => "invalid booking id"
            ];
        }
    }

    public function bookingList()
    {
        return [
            "status" => 'success',
            'data' => $this->bookingRepo->getBookingList()
        ];
    }

    public function getBookingDetailsByRoomId($roomId, $userId)
    {
        return $this->bookingRepo->bookingDetailsByRoomId($roomId, $userId);
    }
}
