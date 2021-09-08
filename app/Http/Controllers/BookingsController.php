<?php

namespace App\Http\Controllers;

use App\Contracts\Service\BookingServiceContract;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use App\Contracts\BookingRepository;
use App\Validators\BookingValidator;

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
        $this->validator  = $validator;
    }

    /**
     * @OA\Post(
     *      path="/book/room",
     *      operationId="BookingRoom",
     *      tags={"Booking"},
     *      summary="Book rooms",
     *      description="Book rooms",
     *      * @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *          @OA\JsonContent(
     *                  required={"room_id","user_id", "room_number"},
     *                  @OA\Property(property="room_id", type="string", example="rooom id"),
     *                  @OA\Property(property="user_id", type="string", example="15471"),
     *                  @OA\Property(property="room_number", type="string", example="room_number"),
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
     */


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->bookService->bookRoom($request->all());

        if (!empty($data['status']) && $data['status'] == 'validation-error') {
            return $this->sendApiValidationError($data['error']);
        }

        if (!empty($data['status']) && $data['status'] == 'success') {
            return $this->sendApiResponse("Success",$data['data']);
        }

        return $this->sendApiError($data['html']);
    }


    /**
     * @OA\Post(
     *      path="/checkin",
     *      operationId="CheckIN",
     *      tags={"Booking"},
     *      summary="Room check in",
     *      description="Room check in",
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
     */

    public function checkin(Request $request)
    {
        $user = \JWTAuth::user();

        if (empty($user)) {
            return $this->sendApiError("The token is invalid", Response::HTTP_FORBIDDEN);
        }

        $data = $this->bookService->checkIn($request->all('room_id'), $user->id);

        if (!empty($data['status']) && $data['status'] == 'validation-error') {
            return $this->sendApiValidationError($data['error']);
        }

        if (!empty($data['status']) && $data['status'] == 'success') {
            return $this->sendApiResponse("Success",$data['data']);
        }

        return $this->sendApiError($data['html']);
    }

    /**
     * @OA\Post(
     *      path="/checkout",
     *      operationId="checkout",
     *      tags={"Booking"},
     *      summary="Room check out",
     *      description="Room check out",
     *      * @OA\RequestBody(
     *          required=true,
     *          description="Pass the room information",
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
     */

    public function checkout(Request $request)
    {
        $user = \JWTAuth::user();

        if (empty($user)) {
            return $this->sendApiError("The token is invalid", Response::HTTP_FORBIDDEN);
        }

        $data = $this->bookService->checkOut($request->all('room_id'), $user->id);

        if (!empty($data['status']) && $data['status'] == 'success') {
            return $this->sendApiResponse("Success",$data['data']);
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
     */

    public function bookingList(Request $request)
    {
        $data = $this->bookService->bookingList();

        if (!empty($data['status']) && $data['status'] == 'success') {
            return $this->sendApiResponse("Success",$data['data']);
        }

        return $this->sendApiError($data['html']);
    }


}
