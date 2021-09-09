<?php
namespace App\Http\Controllers;

use App\Contracts\BookingRepository;
use App\Contracts\Service\BookingServiceContract;
use App\Validators\BookingValidator;
use Illuminate\Http\Request;

/**
 * Class BookingsController.
 *
 * @package namespace App\Http\Controllers;
 */
class BookingsController extends BaseController
{
    /**
     * @var BookingRepository
     */
    protected $repository;

    /**
     * @var BookingValidator
     */
    protected $validator;
    /**
     * @var BookingServiceContract
     */
    private $bookService;

    /**
     * BookingsController constructor.
     *
     * @param BookingServiceContract $bookService
     * @param BookingValidator $validator
     */
    public function __construct(BookingServiceContract $bookService, BookingValidator $validator)
    {
        $this->bookService = $bookService;
        $this->validator = $validator;
    }

    /**
     * @OA\Post(
     *      path="/booking",
     *      operationId="Booking",
     *      tags={"Booking"},
     *      summary="Room book in",
     *      description="Room book in",
     *      * @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *          @OA\JsonContent(
     *                  required={"room_id","user_id"},
     *                  @OA\Property(property="room_id", type="string", example="rooom id"),
     *                  @OA\Property(property="user_id", type="string", example="15471"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function bookingRoom(Request $request)
    {

        $data = $this->bookService->bookRoom($request->all());

        if (!empty($data['status']) && $data['status'] == 'validation-error') {
            return $this->sendApiValidationError($data['error']);
        }

        if (!empty($data['status']) && $data['status'] == 'success') {
            return $this->sendApiResponse("Success", $data['data']);
        }

        return $this->sendApiError($data['html']);
    }


    /**
     * @OA\Post(
     *      path="/check/room-available",
     *      operationId="Booking available",
     *      tags={"Booking available"},
     *      summary="Room book available",
     *      description="Room book available",
     *      * @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *          @OA\JsonContent(
     *                  required={"room_id","user_id"},
     *                  @OA\Property(property="room_id", type="string", example="rooom id"),
     *                  @OA\Property(property="user_id", type="string", example="15471"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function checkRoomAvailable(Request $request)
    {
        $data = $this->bookService->checkRoomAvailability($request->all());

        if (!empty($data['status']) && $data['status'] == 'validation-error') {
            return $this->sendApiValidationError($data['error']);
        }

        return $this->sendApiResponse("Success", $data['data']);
    }


    /**
     * @OA\Get(
     *      path="/booking/list",
     *      operationId="bookinglist",
     *      tags={"Booking"},
     *      summary="Room booking list",
     *      description="Room booking list",
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function bookingList(Request $request)
    {
        $data = $this->bookService->getBookingListByMonth(null);

        if (!empty($data['status']) && $data['status'] == 'success') {
            return $this->sendApiResponse("Success", $data['data']);
        }

        return $this->sendApiError($data['html']);
    }

    /**
     * @OA\Get(
     *      path="/booking/list",
     *      operationId="bookinglist",
     *      tags={"Booking"},
     *      summary="Room booking list",
     *      description="Room booking list",
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @param $booking_id
     * @return \Illuminate\Http\Response
     */
    public function bookingDetails($booking_id)
    {
        $data = $this->bookService->getBookingDetails(['booking_id' => $booking_id]);

        if (!empty($data['status']) && $data['status'] == 'validation-error') {
            return $this->sendApiValidationError($data['error']);
        }

        if (!empty($data['status']) && $data['status'] == 'success') {
            return $this->sendApiResponse("Success", $data['data']);
        }

        return $this->sendApiError($data['html']);
    }


}
