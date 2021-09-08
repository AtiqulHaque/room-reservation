<?php

namespace App\Repositories;

use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\BookingRepository;
use App\Models\Booking;
use App\Validators\BookingValidator;

/**
 * Class BookingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BookingRepositoryEloquent extends BaseRepository implements BookingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Booking::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function bookRoom(array $params = array())
    {
       return $this->create($params);
    }

    public function checkIn($roomId, $userId)
    {
        $room = $this->model->where('user_id', $userId)
            ->where('room_id', $roomId)
            ->first();

        if(empty($room)){
            return false;
        }
        $room->arrival =  Carbon::now();
        return $room->save();

    }

    public function checkOut($roomId, $userId)
    {
        $room = $this->model->where('user_id', $userId)
            ->where('room_id', $roomId)
            ->first();

        if(empty($room)){
            return false;
        }
        $room->checkout =  Carbon::now();
        return $room->save();
    }

    public function bookingDetails($bookingId)
    {
        return $this->model->where('id', $bookingId)
            ->with(['room'])
            ->first();
    }

    public function getBookingList()
    {
        return $this->with([
            'room',
            'user'
        ])->paginate();
    }

    public function bookingDetailsByRoomId($roomId, $userId)
    {
        return $this->model->where('user_id', $userId)
            ->where('room_id', $roomId)
            ->first();
    }
}
